<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\Card;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $gender = '';
    public ?string $default_delivery_address = null;
    public ?string $nif = null;
    public ?string $default_payment_reference = null;
    public ?string $default_payment_type = null;

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'gender' => ['required', 'in:M,F'],
            'default_delivery_address' => ['nullable', 'string', 'max:255'],
            'nif' => ['nullable', 'string', 'max:9'],
            'default_payment_reference' => ['nullable', 'string', 'max:255'],
            'default_payment_type' => ['nullable', 'in:Visa,MB WAY,PayPal'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $validated['type'] = 'pending_member';

        event(new Registered(($user = User::create($validated))));

        // Gera número de cartão único de 6 dígitos
        do {
            $cardNumber = random_int(100000, 999999);
        } while (Card::where('card_number', $cardNumber)->exists());

        Auth::login($user);

        $user->sendEmailVerificationNotification();

        $this->redirectIntended(route('home', absolute: false), navigate: true);

        $user->cardRef()->create([
            'id' => $user->id,
            'card_number' => $cardNumber,
            'balance' => 0.0,
        ]);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name"
            :placeholder="__('Full name')" />

        <!-- Email Address -->
        <flux:input wire:model="email" :label="__('Email address')" type="email" required autocomplete="email"
            placeholder="email@example.com" />

        <!-- Password -->
        <flux:input wire:model="password" :label="__('Password')" type="password" required autocomplete="new-password"
            :placeholder="__('Password')" viewable />

        <!-- Confirm Password -->
        <flux:input wire:model="password_confirmation" :label="__('Confirm password')" type="password" required
            autocomplete="new-password" :placeholder="__('Confirm password')" viewable />

        <!-- Gender -->
        <div>
            <label>{{ __('Gender') }}</label>
            <div class="mt-1">
                <label>
                    <input type="radio" wire:model="gender" name="gender" value="M">
                    {{ __('M') }}
                </label>
                <label class="ml-4">
                    <input type="radio" wire:model="gender" name="gender" value="F">
                    {{ __('F') }}
                </label>
            </div>
        </div>

        <!-- delivery -->
        <flux:input wire:model="default_delivery_address" :label="__('Default Delivery Address ')" type="text"
            autofocus autocomplete="default_delivery_address" :placeholder="__('Delivery Address')" />

        <!-- NIF -->
        <flux:input wire:model="nif" :label="__('NIF ')" type="text" autofocus autocomplete="nif"
            :placeholder="__('NIF')" />

        <!-- Payment type -->
        <div>
            <label>{{ __('Default Payment Type') }}</label>
            <div class="mt-1">
                <label>
                    <input type="radio" wire:model="default_payment_type" name="default_payment_type" value="Visa">
                    {{ __('Visa') }}
                </label>
                <label class="ml-4">
                    <input type="radio" wire:model="default_payment_type" name="default_payment_type" value="PayPal">
                    {{ __('PayPal') }}
                </label>
                <label class="ml-4">
                    <input type="radio" wire:model="default_payment_type" name="default_payment_type" value="MB WAY">
                    {{ __('MB WAY') }}
                </label>
            </div>
        </div>

        <!-- paymente reference -->
        <flux:input wire:model="default_payment_reference" :label="__('Default Paymente Reference ')" type="text"
            autofocus autocomplete="default_payment_reference" :placeholder="__('Paymente Reference')" />


        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
