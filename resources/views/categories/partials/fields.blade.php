@php
    $mode = $mode ?? 'edit';
    $readonly = $mode === 'show';
@endphp

<div class="w-full sm:w-96">
    <flux:input
        name="name"
        label="Name"
        value="{{ $readonly ? $categorie->name : old('name', $categorie->name ?? '') }}"
        :disabled="$readonly"
    />
</div>

<div class="w-full sm:w-96">
    <flux:input
        name="image"
        label="Image"
        value="{{ $readonly ? $categorie->image : old('image', $categorie->image ?? '') }}"
        :disabled="$readonly"
    />
</div>

@if (!$readonly)
    <flux:error name="name" />
    <flux:error name="image" />
@endif
