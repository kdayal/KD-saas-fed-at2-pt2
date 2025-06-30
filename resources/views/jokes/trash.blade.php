<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Trashed Jokes') }}
            </h2>
            <div>
                <a href="{{ route('jokes.index') }}"  {{-- Changed from users.index --}}
                   class="text-sm text-blue-600 hover:text-blue-900 transition ease-in-out duration-150 mr-4">
                    &larr; {{ __('Back to Jokes List') }} {{-- Changed text --}}
                </a>
                @if($jokes->isNotEmpty()) {{-- Changed from $users --}}
                    <form method="POST" action="{{ route('jokes.recover-all') }}" class="inline"> {{-- Changed from users.recover-all --}}
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="text-sm text-green-600 hover:text-green-900 mr-2 px-3 py-1 border border-green-300 rounded hover:bg-green-50 transition ease-in-out duration-150">
                            <i class="fa-solid fa-recycle mr-1"></i>
                            Restore All
                        </button>
                    </form>
                    <form method="POST" action="{{ route('jokes.empty-all') }}" class="inline" onsubmit="return confirm('Are you sure you want to permanently delete all jokes from trash? This action cannot be undone.');"> {{-- Changed from users.empty-all and updated confirm message --}}
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="text-sm text-red-600 hover:text-red-900 px-3 py-1 border border-red-300 rounded hover:bg-red-50 transition ease-in-out duration-150">
                            <i class="fa-solid fa-trash-can mr-1"></i>
                            Empty Trash
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <article class="my-0">
                    {{-- Updated table headers for jokes --}}
                    <header class="grid grid-cols-12 bg-gray-500 text-gray-50 text-lg px-4 py-2">
                        <span class="col-span-1">#</span>
                        <span class="col-span-3">Title</span>
                        <span class="col-span-2">Category</span>
                        <span class="col-span-2">Author</span>
                        <span class="col-span-2">Deleted At</span>
                        <span class="col-span-2 text-center">Actions</span>
                    </header>

                    @if($jokes->isEmpty()) {{-- Changed from $users --}}
                        <p class="p-6 text-center text-gray-500">The trash is empty.</p>
                    @else
                        @foreach ($jokes as $joke) {{-- Changed from $users to $jokes, and $user to $joke --}}
                            <section
                                class="px-4 grid grid-cols-12 py-2 hover:bg-gray-100 border-b border-b-gray-300 transition duration-150 items-center">
                                <p class="col-span-1">{{ $loop->iteration }}</p>

                                <h5 class="col-span-3 text-gray-800">
                                    {{ Str::limit($joke->title, 50) }} {{-- Display joke title --}}
                                </h5>
                                <div class="col-span-2 text-xs text-gray-500">
                                    @forelse($joke->categories as $category)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800 mr-1 mb-1">{{ $category->name }}</span>
                                    @empty
                                        N/A
                                    @endforelse
                                </div>

                                <p class="col-span-2 text-xs text-gray-500">
                                    {{ $joke->user->name ?? 'Unknown' }} {{-- Display joke author --}}
                                </p>
                                <p class="col-span-2 text-xs text-gray-500">
                                    {{ $joke->deleted_at ? $joke->deleted_at->format('j M Y, g:i a') : 'N/A' }}
                                </p>

                                <div class="col-span-2 flex justify-center space-x-2">
                                    {{-- Restore Button --}}
                                    <form method="POST" action="{{ route('jokes.recover-one', $joke->id) }}"> {{-- Changed from users.recover-one --}}
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                title="Restore Joke" {{-- Updated title --}}
                                                class="px-2 py-1 text-xs bg-green-500 text-white rounded hover:bg-green-600 transition ease-in-out duration-150">
                                            <i class="fa-solid fa-undo"></i>
                                        </button>
                                    </form>

                                    {{-- Permanently Delete Button --}}
                                    <form method="POST" action="{{ route('jokes.empty-one', $joke->id) }}" onsubmit="return confirm('Are you sure you want to permanently delete this joke? This action cannot be undone.');"> {{-- Changed from users.empty-one and updated confirm message --}}
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                title="Delete Permanently"
                                                class="px-2 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition ease-in-out duration-150">
                                            <i class="fa-solid fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </section>
                        @endforeach
                    @endif

                    @if($jokes->hasPages()) {{-- Changed from $users --}}
                        <footer class="px-4 pb-2 pt-4 ">
                            {{ $jokes->links() }} {{-- Changed from $users --}}
                        </footer>
                    @endif
                </article>
            </div>
        </div>
    </div>
</x-app-layout>
