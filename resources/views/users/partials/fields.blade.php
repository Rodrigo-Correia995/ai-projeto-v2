@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

{{--
<div class="w-full sm:w-96">
    <flux:input name="id" label="id" value="{{ old('id', $user->id) }}"
        :disabled="$readonly" :readonly="$mode == 'edit'" />
</div>
 --}}
<flux:input name="name" label="Name" value="{{ old('name', $user->name) }}" :disabled="$readonly" />

<flux:input name="email" label="Email" value="{{ old('email', $user->email) }}"
    :disabled="$readonly" />

<flux:input name="password" label="Password" type="password" value="{{ old('password', $user->password) }}"
    :disabled="$readonly" />

<flux:input name="remember_token" label="Remember" value="{{ old('remember_token', $user->remember_token) }}"
    :disabled="$readonly" />

<flux:radio.group name="type" label="Type of member" :disabled="$readonly" class="ps-8 py-2">
    <flux:radio value="member" label="Member" :checked="old('type', $user->type) == 'member'" />
    <flux:radio value="bord" label="Bord" :checked="old('type', $user->type) == 'bord'" />
    <flux:radio value="employee" label="Employee" :checked="old('type', $user->type) == 'employee'" />
    <flux:radio value="pending_member" label="Pending Member" :checked="old('type', $user->type) == 'pending_member'" />
    <flux:error name="type" />
</flux:radio.group>

<flux:input name="blocked" label="Blocked" value="{{ old('blocked', $user->blocked) }}" :disabled="$readonly" />

<flux:radio.group name="gender" label="Gender" :disabled="$readonly" class="ps-8 py-2">
    <flux:radio value="M" label="M" :checked="old('gender', $user->gender) == 'M'" />
    <flux:radio value="F" label="F" :checked="old('gender', $user->gender) == 'F'" />
    <flux:error name="type" />
</flux:radio.group>

<flux:input name="photo" label="Photo" value="{{ old('photo', $user->photo) }}" :disabled="$readonly" />

<flux:input name="default_delivery_address" label="Default Delivery Address" value="{{ old('default_delivery_address', $user->default_delivery_address) }}" :disabled="$readonly" />

<flux:radio.group name="default_payment_type" label="Default Paymente Type" :disabled="$readonly" class="ps-8 py-2">
    <flux:radio value="Visa" label="Visa" :checked="old('default_payment_type', $user->default_payment_type) == 'Visa'" />
    <flux:radio value="PayPal" label="PayPal" :checked="old('default_payment_type', $user->default_payment_type) == 'PayPal'" />
    <flux:radio value="MB WAY" label="MB WAY" :checked="old('default_payment_type', $user->default_payment_type) == 'MB WAY'" />
    <flux:error name="type" />
</flux:radio.group>

<flux:input name="default_payment_reference" label="Default Payment Reference" value="{{ old('default_payment_reference', $user->default_payment_reference) }}" :disabled="$readonly" />

<flux:input name="nif" label="NIF" value="{{ old('nif', $user->nif) }}" :disabled="$readonly" />
