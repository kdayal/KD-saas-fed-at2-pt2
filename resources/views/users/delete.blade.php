<x-app-layout>

    <x-slot name="header">
        {{-- Removed "New User" button and simplified header --}}
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Confirm User Deletion') }}
            </h2>
            <a href="{{route('users.index')}}"
               class="text-sm text-gray-600 hover:text-gray-900 transition ease-in-out duration-150">
                &larr; {{ __('Back to Users List') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <article class="my-0">

                    <header class="bg-red-500 text-white text-lg px-4 py-3"> {{-- Changed header color for emphasis --}}
                        <h5 class="font-semibold">
                            {{ __('Delete User: ') }}
                            <em>{{ $user->name }}</em>
                        </h5>
                    </header>

                    <section class="px-6 py-6 flex flex-col text-gray-800">
                        {{-- User details are kept as per "duplicate show page" instruction --}}
                        <div class="mb-6 p-4 border border-yellow-300 bg-yellow-50 rounded-md">
                            <p class="text-sm text-yellow-700">
                                <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                                {{ __('Are you sure you want to delete this user? This action will move the user to the trash and can be undone from there unless permanently deleted from the trash.') }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 mb-6">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Name:</p>
                                <p class="mt-1 text-gray-900">
                                    {{ $user->name ?? "No Name provided" }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-500 text-sm font-medium">Email:</p>
                                <p class="mt-1 text-gray-900">
                                    {{ $user->email ?? "No Email Provided" }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-500 text-sm font-medium">Role:</p>
                                <p class="mt-1 text-gray-900">
                                    {{ $user->role ?? "No Role Provided" }} {{-- Assuming 'role' attribute exists --}}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-500 text-sm font-medium">Added:</p>
                                <p class="mt-1 text-gray-900">
                                    {{ $user->created_at->format('j M Y, g:i a') }}
                                </p>
                            </div>
                        </div>


                        {{-- Updated form for CONFIRM and CANCEL --}}
                        <form method="POST"
                              class="flex mt-8 gap-4 justify-end" {{-- Aligned buttons to the right --}}
                              action="{{ route('users.destroy', $user) }}"> {{-- Action points to destroy route --}}

                            @csrf
                            @method('DELETE') {{-- Crucial for soft delete via resource controller --}}

                            <a href="{{ route('users.index') }}"
                               class="px-4 py-2 bg-gray-200 text-gray-800 border border-gray-300 rounded-md
                                      hover:bg-gray-300 transition ease-in-out duration-150 text-sm font-medium">
                                <i class="fa-solid fa-times mr-1"></i>
                                {{ __('Cancel') }}
                            </a>

                            <button type="submit"
                                    class="px-4 py-2 bg-red-600 text-white border border-transparent rounded-md
                                           hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2
                                           transition ease-in-out duration-150 text-sm font-medium">
                                <i class="fa-solid fa-trash-alt mr-1"></i>
                                {{ __('Confirm Delete') }}
                            </button>

                        </form>

                    </section>

                </article>

            </div>
        </div>
    </div>
</x-app-layout>
