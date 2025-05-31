<x-layouts.main-content :title="'Add Shipping Cost Interval'" :heading="'Add New Shipping Cost Interval'" subheading="Define a new shipping cost interval.">

    <form method="POST" action="{{ route('shipping_costs.store') }}" class="max-w-lg space-y-6">
        @csrf

        <flux:input
            type="number"
            name="min_value_threshold"
            label="Min Value Threshold (€)"
            value="{{ old('min_value_threshold') }}"
            step="0.01"
            required
        />

        <flux:input
            type="number"
            name="max_value_threshold"
            label="Max Value Threshold (€)"
            value="{{ old('max_value_threshold') }}"
            step="0.01"
            required
        />

        <flux:input
            type="number"
            name="shipping_cost"
            label="Shipping Cost (€)"
            value="{{ old('shipping_cost') }}"
            step="0.01"
            required
        />

        <flux:button variant="primary" type="submit" class="uppercase">
            Save
        </flux:button>
        <flux:button variant="filled" class="uppercase ms-4" href="{{ route('shipping_costs.index') }}">
            Cancel
        </flux:button>
    </form>

</x-layouts.main-content>
