<x-layouts.main-content :title="__('Categories')"
    heading="List of Categories"
    subheading="Manage the available Categories">

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex justify-start">
            <div class="my-4 p-6 max-w-7xl mx-auto w-full">
                <div class="flex items-center gap-4 mb-4">
                    <flux:button variant="primary" href="{{ route('categories.create') }}">
                        Create a new category
                    </flux:button>
                </div>

                <div class="my-4 font-base text-sm text-gray-700 dark:text-gray-300 overflow-x-auto">
                    <table class="table-auto border-collapse w-full max-w-7xl mx-auto">
                        <thead>
                            <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                                <th class="px-4 py-3 text-left min-w-[80px]">ID</th>
                                <th class="px-4 py-3 text-left min-w-[200px]">Name</th>
                                <th class="px-4 py-3 text-left min-w-[200px]">Image</th>
                                <th class="px-4 py-3 text-left">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                                    <td class="px-4 py-3">{{ $category->id }}</td>
                                    <td class="px-4 py-3">{{ $category->name }}</td>
                                    <td class="px-4 py-3">{{ $category->image }}</td>
                                    <td class="px-4 py-3 flex space-x-4">
                                        <a href="{{ route('categories.show', $category) }}">
                                            <flux:icon.eye class="size-5 hover:text-gray-600" />
                                        </a>
                                        <a href="{{ route('categories.edit', $category) }}">
                                            <flux:icon.pencil-square class="size-5 hover:text-blue-600" />
                                        </a>
                                        <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">
                                                <flux:icon.trash class="size-5 hover:text-red-600" />
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.main-content>
