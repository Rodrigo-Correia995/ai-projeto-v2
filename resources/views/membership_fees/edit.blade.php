<x-layouts.main-content :title="__('Membership Fee')" heading="Edit Membership Fee" subheading="Set the current registration fee for new members.">

    <form action="{{ route('membership_fees.update') }}" method="POST" class="max-w-md mx-auto space-y-6">
        @csrf
        @method('PUT')

        <flux:input
            type="number"
            step="0.01"
            min="0"
            name="membership_fee"
            label="Membership Fee (€)"
            value="{{ old('membership_fee', $settings->membership_fee) }}"
            required
        />

        <div class="flex space-x-4">
            <flux:button variant="primary" type="submit" class="uppercase">
                Update Fee
            </flux:button>
            <flux:button variant="filled" class="uppercase" href="{{ route('membership_fees.edit') }}">
                Cancel
            </flux:button>
        </div>
    </form>

</x-layouts.main-content>
