<x-app-layout>

    <x-slot name="header">
        <a href="{{route('users.index')}}" class="grow">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight grow">
                {{ __('Users') }}
            </h2>
        </a>

        <a href="{{ route('users.create') }}"
           class="text-green-800 hover:text-green-100
                 bg-gray-100 hover:bg-green-800
                 border border-gray-300
                 rounded-lg
                 transition ease-in-out duration-200
                 px-4 py-1">
            New User
            <i class="fa-solid fa-user-plus"></i>
        </a>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <article class="my-0">

                    <header class="bg-gray-500 text-gray-50 text-lg px-4 py-2">
                        <h5>
                            {{ __('Details for') }}
                            <em>{{ $user->name }}</em>
                        </h5>
                    </header>

                    <section class="px-6 py-6 text-gray-800"> {{-- Added padding to section --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 mb-6"> {{-- Improved layout for details --}}
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Full Name:</p>
                                <p class="mt-1 text-gray-900">
                                    {{ $user->name ?? "No Name provided" }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-500 text-sm font-medium">Given Name:</p>
                                <p class="mt-1 text-gray-900">
                                    {{ $user->given_name ?? "N/A" }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-500 text-sm font-medium">Family Name:</p>
                                <p class="mt-1 text-gray-900">
                                    {{ $user->family_name ?? "N/A" }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-500 text-sm font-medium">Email:</p>
                                <p class="mt-1 text-gray-900">
                                    {{ $user->email ?? "No Email Provided" }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-500 text-sm font-medium">Role(s):</p> {{-- Changed from Role to Role(s) --}}
                                <div class="mt-1 text-gray-900">
                                    @forelse ($user->getRoleNames() as $roleName)
                                        <span class="text-xs bg-gray-700 text-gray-100 rounded-full px-2 py-0.5 mr-1 mb-1 inline-block">
                                            {{ $roleName }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-gray-500">No Role Provided</span>
                                    @endforelse
                                </div>
                            </div>

                            <div>
                                <p class="text-gray-500 text-sm font-medium">Added:</p>
                                <p class="mt-1 text-gray-900">
                                    {{ $user->created_at->format('j M Y, g:i a') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-500 text-sm font-medium">Last Updated:</p>
                                <p class="mt-1 text-gray-900">
                                    {{ $user->updated_at->format('j M Y, g:i a') }}
                                </p>
                            </div>
                        </div>


                        {{-- Action Buttons --}}
                        <div class="flex mt-8 gap-4"> {{-- Removed form wrapper for non-POST actions --}}
                            <a href="{{ route('users.index') }}"
                               class="px-4 py-2 bg-gray-200 text-gray-800 border border-gray-300 rounded-md
                                      hover:bg-gray-300 transition ease-in-out duration-150 text-sm font-medium">
                                <i class="fa-solid fa-list mr-1"></i> {{-- Changed icon --}}
                                {{ __('All Users') }}
                            </a>

                            @can('update', $user) {{-- Authorization check --}}
                            <a href="{{ route('users.edit', $user) }}"
                               class="px-4 py-2 bg-yellow-500 text-white border border-transparent rounded-md
                                        hover:bg-yellow-600 transition ease-in-out duration-150 text-sm font-medium">
                                <i class="fa-solid fa-user-edit mr-1"></i>
                                {{ __('Edit') }}
                            </a>
                            @endcan

                            @can('delete', $user) {{-- Authorization check --}}
                            <a href="{{ route('users.delete', $user) }}" 
                               class="px-4 py-2 bg-red-600 text-white border border-transparent rounded-md
                                        hover:bg-red-700 transition ease-in-out duration-150 text-sm font-medium">
                                <i class="fa-solid fa-user-minus mr-1"></i>
                                {{ __('Delete') }}
                            </a>
                            @endcan
                        </div>

                    </section>

                </article>

            </div>
        </div>
    </div>
</x-app-layout>
