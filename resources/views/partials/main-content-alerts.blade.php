<div class="relative mb-2 w-full">
    @if(session('alert-msg'))
        <flux:callout x-data="{ visible: true }" x-show="visible"
                      variant="{{ session('alert-type', 'info') }}">
            <div>{!! session('alert-msg') !!}</div>
            <x-slot name="controls">
                <flux:button icon="x-mark" variant="ghost" x-on:click="visible = false" />
            </x-slot>
        </flux:callout>
    @endif

    @if($errors->any())
        <flux:callout x-data="{ visible: true }" x-show="visible"
                      variant="warning" icon="exclamation-circle">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <x-slot name="controls">
                <flux:button icon="x-mark" variant="ghost" x-on:click="visible = false" />
            </x-slot>
        </flux:callout>
    @endif
</div>