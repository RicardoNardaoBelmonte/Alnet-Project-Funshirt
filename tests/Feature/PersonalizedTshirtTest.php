<?php

use App\Models\Tshirt;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('local');
});

test('guests cannot access personalized tshirt pages', function () {
    $this->get(route('my.tshirts.index'))->assertRedirect(route('login'));
    $this->get(route('my.tshirts.create'))->assertRedirect(route('login'));
});

test('authenticated user can view their personalized tshirts list', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('my.tshirts.index'))
        ->assertOk()
        ->assertSee('My Personalized T-Shirts');
});

test('authenticated user can create a personalized tshirt', function () {
    $user = User::factory()->create();
    $file = UploadedFile::fake()->image('design.jpg');

    $response = $this->actingAs($user)->post(route('my.tshirts.store'), [
        'name' => 'My Cool Design',
        'description' => 'A unique design',
        'image' => $file,
    ]);

    $response->assertRedirect();

    $tshirt = Tshirt::where('name', 'My Cool Design')->first();
    expect($tshirt)->not->toBeNull();
    expect($tshirt->customer_id)->not->toBeNull();
    expect((float) $tshirt->price)->toBe((float) config('tshirt.personalized_price'));

    Storage::disk('local')->assertExists($tshirt->image_url);
});

test('user cannot view another users personalized tshirt', function () {
    $owner = User::factory()->create();
    $customer = $owner->customer()->create([]);

    $tshirt = Tshirt::create([
        'customer_id' => $customer->id,
        'name' => 'Private Design',
        'price' => config('tshirt.personalized_price'),
        'image_url' => 'personalizedtshirts/fake.jpg',
    ]);

    $other = User::factory()->create();

    $this->actingAs($other)
        ->get(route('my.tshirts.show', $tshirt))
        ->assertForbidden();
});

test('owner can delete their personalized tshirt', function () {
    $user = User::factory()->create();
    $customer = $user->customer()->create([]);
    Storage::disk('local')->put('personalizedtshirts/test.jpg', 'fake-content');

    $tshirt = Tshirt::create([
        'customer_id' => $customer->id,
        'name' => 'Design to Delete',
        'price' => config('tshirt.personalized_price'),
        'image_url' => 'personalizedtshirts/test.jpg',
    ]);

    $this->actingAs($user)
        ->delete(route('my.tshirts.destroy', $tshirt))
        ->assertRedirect(route('my.tshirts.index'));

    expect(Tshirt::find($tshirt->id))->toBeNull();
    Storage::disk('local')->assertMissing('personalizedtshirts/test.jpg');
});

test('cart is empty by default', function () {
    $this->get(route('shop.cart.show'))
        ->assertOk()
        ->assertSee('Your cart is empty');
});

test('anyone can add a catalog tshirt to cart', function () {
    $tshirt = Tshirt::factory()->create([
        'customer_id' => null,
        'price' => 29.99,
    ]);

    $this->post(route('shop.cart.add', $tshirt), [
        'size' => 'M',
        'quantity' => 2,
    ])->assertRedirect(route('shop.cart.show'));

    $cart = session('tshirt_cart');
    expect($cart)->not->toBeEmpty();
    expect(array_values($cart)[0]['tshirt_id'])->toBe($tshirt->id);
    expect(array_values($cart)[0]['quantity'])->toBe(2);
});

test('adding same tshirt size color combination increases quantity', function () {
    $tshirt = Tshirt::factory()->create(['customer_id' => null, 'price' => 20.00]);

    $this->post(route('shop.cart.add', $tshirt), ['size' => 'L', 'quantity' => 1]);
    $this->post(route('shop.cart.add', $tshirt), ['size' => 'L', 'quantity' => 2]);

    $cart = session('tshirt_cart');
    expect(array_values($cart)[0]['quantity'])->toBe(3);
});

test('cart can be cleared', function () {
    $tshirt = Tshirt::factory()->create(['customer_id' => null, 'price' => 20.00]);
    $this->post(route('shop.cart.add', $tshirt), ['size' => 'M', 'quantity' => 1]);

    $this->delete(route('shop.cart.clear'));

    expect(session('tshirt_cart'))->toBeNull();
});
