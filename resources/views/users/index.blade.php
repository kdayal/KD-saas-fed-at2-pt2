<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center"> {{-- Added items-center for better alignment --}}
            <a href="{{route('users.index')}}" class="grow">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight"> {{-- Removed grow from here --}}
                    {{ __('Users') }}
                </h2>
            </a>

            <div class="flex items-center space-x-2"> {{-- Grouped button and search --}}
                <form action="{{ route('users.index') }}" method="GET" class="flex">
                    <x-text-input id="search"
                                  type="text"
                                  name="search"
                                  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm rounded-r-none text-sm" {{-- Adjusted styling --}}
                                  placeholder="Search users..."
                                  :value="$search??''"
                    />
                    <button type="submit"
                            class="inline-flex items-center px-3 py-2 bg-gray-700 border border-transparent rounded-r-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{-- Removed icon text for cleaner button --}}
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>

                <a href="{{ route('users.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fa-solid fa-user-plus pr-1" aria-hidden="true"></i>
                    New User
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <article class="my-0">
                    {{-- Corrected grid to grid-cols-12 and adjusted column spans for header --}}
                    <header class="grid grid-cols-12 bg-gray-500 text-gray-50 text-lg px-4 py-2">
                        <span class="col-span-1">#</span>
                        <span class="col-span-5">User</span> {{-- Adjusted span --}}
                        <span class="col-span-1">Added</span>
                        <span class="col-span-1">Role(s)</span> {{-- Changed text --}}
                        <span class="col-span-4 text-center">Actions</span> {{-- Adjusted span and centered --}}
                    </header>

                    @if($users->isEmpty())
                        <p class="p-6 text-center text-gray-500">No users found.</p>
                    @else
                        @foreach ($users as $user)
                            <section
                                class="px-4 grid grid-cols-12 py-2 hover:bg-gray-100 border-b border-b-gray-300 transition duration-150 items-center"> {{-- Added items-center --}}
                                <p class="col-span-1 text-sm text-gray-500">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</p> {{-- Corrected loop index for pagination --}}

                                <div class="col-span-5 text-gray-800"> {{-- Changed h5 to div for better structure --}}
                                    <p class="font-medium">{{ $user->name }}</p>
                                    <small class="text-xs text-gray-500">
                                        {{ $user->email }}
                                    </small>
                                </div>

                                <p class="text-xs text-gray-500 col-span-1"> {{-- Adjusted class --}}
                                    {{ $user->created_at->format('j M Y') }}
                                </p>

                                <div class="col-span-1"> {{-- Changed p to div for multiple roles --}}
                                    @forelse ($user->getRoleNames() as $roleName)
                                        <span class="text-xs bg-gray-700 text-gray-100 rounded-full px-2 py-0.5 mr-1 mb-1 inline-block">
                                            {{ $roleName }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-gray-500">No Role</span>
                                    @endforelse
                                </div>

                                {{-- Actions are now outside the form for delete, and wrapped with authorization --}}
                                <div class="col-span-4 flex justify-center space-x-2"> {{-- Centered actions --}}
                                    @can('view', $user) {{-- Assuming a 'view' ability in UserPolicy or a general permission --}}
                                    <a href="{{ route('users.show', $user) }}"
                                       class="px-2 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600" title="Show">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    @endcan

                                    @can('update', $user)
                                    <a href="{{ route('users.edit', $user) }}"
                                       class="px-2 py-1 text-xs bg-yellow-500 text-white rounded hover:bg-yellow-600" title="Edit">
                                        <i class="fa-solid fa-user-edit"></i>
                                    </a>
                                    @endcan

                                    @can('delete', $user)
                                    <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this user? This will move them to trash.');">
                                        @csrf
                                        @method('DELETE') {{-- Changed from users.delete to users.destroy for resource controller --}}
                                        <button type="submit"
                                                class="px-2 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700" title="Delete">
                                            <i class="fa-solid fa-user-minus"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </section>
                        @endforeach
                    @endif

                    @if ($users->hasPages())
                    <footer class="px-4 pb-2 pt-4">
                        {{ $users->links() }}
                    </footer>
                    @endif
                </article>
            </div>
        </div>
    </div>
</x-app-layout>
