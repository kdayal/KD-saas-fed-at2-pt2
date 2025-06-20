<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Categories') }}
            </h2>
            <div class="flex items-center space-x-2">
                
                <a href="{{ route('admin.categories.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fa-solid fa-plus pr-1" aria-hidden="true"></i>
                    New Category
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <article class="my-0">
                    {{-- Header for the list --}}
                    <header class="grid grid-cols-12 bg-gray-500 text-gray-50 text-lg px-4 py-2">
                        <span class="col-span-1">#</span>
                        <span class="col-span-4">Name</span>         
                        <span class="col-span-5">Description</span>  
                        <span class="col-span-2 text-center">Actions</span> 
                    </header>

                    @if(session('success'))
                        <div class="m-4 p-4 bg-green-100 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="m-4 p-4 bg-red-100 text-red-700 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($categories->isEmpty())
                        <p class="p-6 text-center text-gray-500">No categories found.</p>
                    @else
                        @foreach ($categories as $category)
                            <section
                                class="px-4 grid grid-cols-12 py-2 hover:bg-gray-100 border-b border-b-gray-300 transition duration-150 items-center">
                                <p class="col-span-1 text-sm text-gray-500">{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</p>

                                <div class="col-span-4 text-gray-800">
                                    <p class="font-medium">{{ $category->name }}</p>
                                </div>

                                <p class="col-span-5 text-xs text-gray-500">
                                    {{ Str::limit($category->description, 100) }}
                                </p>

                                <div class="col-span-2 flex justify-center space-x-2">
                                    {{-- Edit Button --}}
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                       class="px-2 py-1 text-xs bg-yellow-500 text-white rounded hover:bg-yellow-600" title="Edit">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                    {{-- Delete Button --}}
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this category? This will not delete jokes associated with it.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-2 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </section>
                        @endforeach
                    @endif

                    @if ($categories->hasPages())
                    <footer class="px-4 pb-2 pt-4">
                        {{ $categories->links() }}
                    </footer>
                    @endif
                </article>
            </div>
        </div>
    </div>
</x-app-layout>
