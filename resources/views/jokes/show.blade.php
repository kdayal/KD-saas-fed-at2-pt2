<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <a href="{{route('jokes.index')}}" class="grow">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight grow">
                    {{ __('Jokes') }}
                </h2>
            </a>
            <div>
                <a href="{{ route('jokes.create') }}"
                   class="text-green-800 hover:text-green-100
                         bg-gray-100 hover:bg-green-800
                         border border-gray-300
                         rounded-lg
                         transition ease-in-out duration-200
                         px-4 py-1">
                    New Joke
                    <i class="fa-solid fa-plus"></i>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <article class="my-0">

                    <header class="bg-gray-500 text-gray-50 text-lg px-4 py-2">
                        <h5>
                            {{ __('Joke Details') }}
                        </h5>
                    </header>

                    <section class="px-6 py-6 text-gray-800">

                        <div class="mb-4">
                            <p class="text-gray-500 text-sm font-medium">Title:</p>
                            <h3 class="mt-1 text-xl font-semibold text-gray-900">
                                {{ $joke->title ?? "No Title provided" }}
                            </h3>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-500 text-sm font-medium">Content:</p>
                            <p class="mt-1 text-gray-700 whitespace-pre-wrap">
                                {{ $joke->content ?? "No Content Provided" }}
                            </p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-500 text-sm font-medium">Category:</p>
                            <p class="mt-1 text-gray-700">
                                {{ $joke->category ?? "N/A" }}
                            </p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-500 text-sm font-medium">Author:</p>
                            <p class="mt-1 text-gray-700">
                                {{ $joke->user->name ?? "Unknown Author" }}
                            </p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-500 text-sm font-medium">Added:</p>
                            <p class="mt-1 text-gray-700">
                                {{ $joke->created_at->format('j M Y, g:i a') }}
                            </p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-500 text-sm font-medium">Last Updated:</p>
                            <p class="mt-1 text-gray-700">
                                {{ $joke->updated_at->format('j M Y, g:i a') }}
                            </p>
                        </div>

                        <div class="flex mt-8 gap-4">
                            <a href="{{ route('jokes.index') }}"
                               class="px-4 py-2 bg-gray-200 text-gray-800 border border-gray-300 rounded-md
                                      hover:bg-gray-300 transition ease-in-out duration-150 text-sm font-medium">
                                <i class="fa-solid fa-list mr-1"></i>
                                {{ __('All Jokes') }}
                            </a>

                            {{-- Add authorization checks here if needed --}}
                            {{-- @can('update', $joke) --}}
                            <a href="{{ route('jokes.edit', $joke) }}"
                               class="px-4 py-2 bg-yellow-500 text-white border border-transparent rounded-md
                                        hover:bg-yellow-600 transition ease-in-out duration-150 text-sm font-medium">
                                <i class="fa-solid fa-edit mr-1"></i>
                                {{ __('Edit') }}
                            </a>
                            {{-- @endcan --}}

                            {{-- @can('delete', $joke) --}}
                            <a href="{{ route('jokes.delete', $joke) }}" {{-- Link to delete confirmation page --}}
                               class="px-4 py-2 bg-red-600 text-white border border-transparent rounded-md
                                        hover:bg-red-700 transition ease-in-out duration-150 text-sm font-medium">
                                <i class="fa-solid fa-trash mr-1"></i>
                                {{ __('Delete') }}
                            </a>
                            {{-- @endcan --}}
                        </div>

                    </section>
                </article>
            </div>
        </div>
    </div>
</x-app-layout>
