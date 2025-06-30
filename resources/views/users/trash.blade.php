<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Trashed Users') }}
            </h2>
            <div>
                <a href="{{ route('users.index') }}"
                   class="text-sm text-blue-600 hover:text-blue-900 transition ease-in-out duration-150 mr-4">
                    &larr; {{ __('Back to Users List') }}
                </a>
                @if($users->isNotEmpty())
                    <form method="POST" action="{{ route('users.recover-all') }}" class="inline">
                        @csrf
                        @method('PATCH') {{-- Assuming PATCH for recover all --}}
                        <button type="submit"
                                class="text-sm text-green-600 hover:text-green-900 mr-2 px-3 py-1 border border-green-300 rounded hover:bg-green-50 transition ease-in-out duration-150">
                            <i class="fa-solid fa-recycle mr-1"></i>
                            Restore All
                        </button>
                    </form>
                    <form method="POST" action="{{ route('users.empty-all') }}" class="inline" onsubmit="return confirm('Are you sure you want to permanently delete all users from trash? This action cannot be undone.');">
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
                    <header class="grid grid-cols-12 bg-gray-500 text-gray-50 text-lg px-4 py-2">
                        <span class="col-span-1">#</span>
                        <span class="col-span-3">User</span>
                        <span class="col-span-2">Email</span>
                        <span class="col-span-2">Role</span>
                        <span class="col-span-2">Deleted At</span>
                        <span class="col-span-2 text-center">Actions</span>
                    </header>

                    @if($users->isEmpty())
                        <p class="p-6 text-center text-gray-500">The trash is empty.</p>
                    @else
                        @foreach ($users as $user)
                            <section
                                class="px-4 grid grid-cols-12 py-2 hover:bg-gray-100 border-b border-b-gray-300 transition duration-150 items-center">
                                <p class="col-span-1">{{ $loop->iteration }}</p>

                                <h5 class="col-span-3 text-gray-800">
                                    {{ $user->name }}
                                </h5>
                                <p class="col-span-2 text-xs text-gray-500">{{ $user->email }}</p>

                                <p class="col-span-2">
                                     @foreach ($user->getRoleNames() as $roleName)
                                        <span class="text-xs bg-gray-700 text-gray-100 rounded-full px-2 py-0.5">{{ $roleName }}</span>
                                    @endforeach
                                </p>
                                <p class="col-span-2 text-xs text-gray-500">
                                    {{ $user->deleted_at ? $user->deleted_at->format('j M Y, g:i a') : 'N/A' }}
                                </p>

                                <div class="col-span-2 flex justify-center space-x-2">
                                    {{-- Restore Button --}}
                                    <form method="POST" action="{{ route('users.recover-one', $user->id) }}"> {{-- Assuming $user->id for trashed items --}}
                                        @csrf
                                        @method('PATCH') {{-- Or PUT, depending on your route definition --}}
                                        <button type="submit"
                                                title="Restore User"
                                                class="px-2 py-1 text-xs bg-green-500 text-white rounded hover:bg-green-600 transition ease-in-out duration-150">
                                            <i class="fa-solid fa-undo"></i>
                                        </button>
                                    </form>

                                    {{-- Permanently Delete Button --}}
                                    <form method="POST" action="{{ route('users.empty-one', $user->id) }}" onsubmit="return confirm('Are you sure you want to permanently delete this user? This action cannot be undone.');"> {{-- Assuming $user->id for trashed items --}}
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

                    @if($users->hasPages())
                        <footer class="px-4 pb-2 pt-4 ">
                            {{ $users->links() }}
                        </footer>
                    @endif
                </article>
            </div>
        </div>
    </div>
</x-app-layout>
