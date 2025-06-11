<div {{ $attributes }}>
    <form method="GET" action="{{ $filterAction }}">
        <div class="flex justify-between space-x-3">
            <div class="grow flex flex-col space-y-2">

                <div>
                    <flux:input name="id" label="ID" class="grow" value="{{ $id }}" />
                </div>

                  <div>
                    <flux:input name="card_id" label="Card Id" class="grow" value="{{ $card_id }}" />
                </div>

            </div>
            <div class="grow-0 flex flex-col space-y-3 justify-start">
                <div class="pt-6">
                    <flux:button variant="primary" type="submit">Filter</flux:button>
                </div>
                <div>
                    <flux:button variant="filled" :href="$resetUrl">Cancel</flux:button>
                </div>
            </div>
        </div>
    </form>
</div>
