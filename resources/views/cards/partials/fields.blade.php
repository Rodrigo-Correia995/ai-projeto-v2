@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<div class="w-full sm:w-96">
<flux:input name="id" label="id"
value="{{ old('id', $card->id) }}"
:disabled="$readonly" :readonly="$mode == 'edit'"/>
</div>

<div class="w-full sm:w-96">
<flux:input name="owner" label="Owner"
value="{{ old('owner', $card->userRef->name) }}"
:disabled="$readonly" :readonly="$mode == 'edit'"/>
</div>

<flux:input name="card_number" label="Card Number" value="{{ old('name', $card->card_number) }}" :disabled="$readonly" />

<flux:input name="balance" label="Balance" value="{{ old('balance', $card->balance) }}" :disabled="$readonly" />

