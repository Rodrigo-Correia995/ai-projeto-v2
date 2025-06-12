@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp


<div class="w-full sm:w-96">
    <flux:input name="id" label="id" value="{{ old('id', $operation->id) }}"
        :disabled="$readonly" :readonly="$mode == 'edit'" />
</div>

<flux:input name="card_id" label="Card ID" value="{{ old('card_id', $operation->card_id) }}" :disabled="$readonly" />

<flux:radio.group name="type" label="Type of opertation" :disabled="$readonly" class="ps-8 py-2">
    <flux:radio value="credit" label="Credit" :checked="old('type', $operation->type) == 'credit'" />
    <flux:radio value="debit" label="Debit" :checked="old('type', $operation->type) == 'debit'" />
    <flux:error name="type" />
</flux:radio.group>

<flux:input name="value" label="Value" value="{{ old('value', $operation->value) }}" :disabled="$readonly" />

<flux:radio.group name="debit_type" label="Debit Type" :disabled="$readonly" class="ps-8 py-2">
    <flux:radio value="order" label="Order" :checked="old('debit_type', $operation->debit_type) == 'order'" />
    <flux:radio value="membership_fee" label="Membership" :checked="old('debit_type', $operation->debit_type) == 'membership_fee'" />
    <flux:error name="type" />
</flux:radio.group>

<flux:radio.group name="credit_type" label="Debit Type" :disabled="$readonly" class="ps-8 py-2">
    <flux:radio value="payment" label="Payment" :checked="old('credit_type', $operation->credit_type) == 'payment'" />
    <flux:radio value="order_cancellation" label="Membership" :checked="old('credit_type', $operation->credit_type) == 'order_cancellation'" />
    <flux:error name="type" />
</flux:radio.group>


<flux:radio.group name="payment_type" label="Paymente Type" :disabled="$readonly" class="ps-8 py-2">
    <flux:radio value="Visa" label="Visa" :checked="old('payment_type', $operation->payment_type) == 'Visa'" />
    <flux:radio value="PayPal" label="PayPal" :checked="old('payment_type', $operation->payment_type) == 'PayPal'" />
    <flux:radio value="MB WAY" label="MB WAY" :checked="old('payment_type', $operation->payment_type) == 'MB WAY'" />
    <flux:error name="type" />
</flux:radio.group>

<flux:input name="payment_reference" label="Payment Reference" value="{{ old('payment_reference', $operation->payment_reference) }}" :disabled="$readonly" />

<flux:input name="order_id" label="Order ID" value="{{ old('order_id', $operation->order_id) }}" :disabled="$readonly" />
