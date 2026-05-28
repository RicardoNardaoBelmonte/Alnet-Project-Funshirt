<?php

namespace App\Providers;

use App\Mime\ImageMimeTypeGuesser;
use App\Models\Course;
use App\Models\User;
use App\Policies\AdministrativePolicy;
use Carbon\CarbonImmutable;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter as FlyLocalAdapter;
use League\Flysystem\UnixVisibility\PortableVisibilityConverter;
use League\Flysystem\Visibility;
use League\MimeTypeDetection\ExtensionMimeTypeDetector;
use Symfony\Component\Mime\MimeTypes;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->extendLocalFilesystemDriver();
        MimeTypes::getDefault()->registerGuesser(new ImageMimeTypeGuesser);

        Gate::policy(User::class, AdministrativePolicy::class);

        Gate::define('use-cart', function (?User $user) {
            return $user === null || $user->type == 'A' || $user->type == 'S';
        });

        Gate::define('confirm-cart', function (User $user) {
            return $user->type == 'A' || $user->type == 'S';
        });

        Gate::define('admin', function (User $user) {
            // Only "administrator" users can "admin"
            return $user->admin;
        });
        try {
            // View::share adds data (variables) that are shared through all views
            View::share('sharedCourses', Course::orderBy('type')->orderBy('abbreviation')->get());
        } catch (\Exception $e) {
            // No need to do anything – this just ensures that no exception is
            // thrown if "courses" table does not exist when running
            // "php artisan migrate" for the first time
        }
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }

    /**
     * Override the local filesystem driver to use ExtensionMimeTypeDetector,
     * avoiding a hard dependency on the PHP fileinfo extension.
     */
    protected function extendLocalFilesystemDriver(): void
    {
        Storage::extend('local', function ($app, $config) {
            $visibility = PortableVisibilityConverter::fromArray(
                $config['permissions'] ?? [],
                $config['directory_visibility'] ?? $config['visibility'] ?? Visibility::PRIVATE
            );

            $links = ($config['links'] ?? null) === 'skip'
                ? FlyLocalAdapter::SKIP_LINKS
                : FlyLocalAdapter::DISALLOW_LINKS;

            $adapter = new FlyLocalAdapter(
                $config['root'],
                $visibility,
                $config['lock'] ?? LOCK_EX,
                $links,
                new ExtensionMimeTypeDetector
            );

            return new FilesystemAdapter(
                new Filesystem($adapter, $config),
                $adapter,
                $config
            );
        });
    }
}
