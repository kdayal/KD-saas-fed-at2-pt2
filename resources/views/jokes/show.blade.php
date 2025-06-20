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
                                {{ $joke->body ?? "No Content Provided" }} {{-- Changed from $joke->content to $joke->body --}}
                            </p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-500 text-sm font-medium">Categories:</p> {{-- Changed from Category to Categories --}}
                            <div class="mt-1 flex flex-wrap gap-2">
                                @forelse ($joke->categories as $category)
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">{{ $category->name }}</span>
                                @empty
                                    <span class="text-gray-500 text-sm">N/A</span> {{-- Changed from "No categories assigned." --}}
                                @endforelse
                            </div>
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

                        {{-- Added Like/Dislike section here --}}
                        <div class="mt-6 border-t pt-4 flex items-center space-x-6">
                            <span class="text-sm text-gray-600">Rate this joke:</span>
                            {{-- Like Button --}}
                            <form action="{{ route('jokes.interact', $joke) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="interaction_type" value="like">
                                <button type="submit"
                                        class="flex items-center px-3 py-1 rounded-md border {{ $joke->isLikedByAuthUser() ? 'bg-blue-500 text-white border-blue-500' : 'bg-gray-100 text-gray-700 hover:bg-blue-100 border-gray-300' }}">
                                    <i class="fa-solid fa-thumbs-up mr-2"></i>
                                    <span>Like ({{ $joke->likesCount() }})</span>
                                </button>
                            </form>

                            {{-- Dislike Button --}}
                            <form action="{{ route('jokes.interact', $joke) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="interaction_type" value="dislike">
                                <button type="submit"
                                        class="flex items-center px-3 py-1 rounded-md border {{ $joke->isDislikedByAuthUser() ? 'bg-red-500 text-white border-red-500' : 'bg-gray-100 text-gray-700 hover:bg-red-100 border-gray-300' }}">
                                    <i class="fa-solid fa-thumbs-down mr-2"></i>
                                    <span>Dislike ({{ $joke->dislikesCount() }})</span>
                                </button>
                            </form>
                        </div>

                        <div class="flex mt-8 gap-4">
                            <a href="{{ route('jokes.index') }}"
                               class="px-4 py-2 bg-gray-200 text-gray-800 border border-gray-300 rounded-md
                                      hover:bg-gray-300 transition ease-in-out duration-150 text-sm font-medium">
                                <i class="fa-solid fa-list mr-1"></i>
                                {{ __('All Jokes') }}
                            </a>

                            @can('update', $joke) {{-- Added authorization check --}}
                            <a href="{{ route('jokes.edit', $joke) }}"
                               class="px-4 py-2 bg-yellow-500 text-white border border-transparent rounded-md
                                        hover:bg-yellow-600 transition ease-in-out duration-150 text-sm font-medium">
                                <i class="fa-solid fa-edit mr-1"></i>
                                {{ __('Edit') }}
                            </a>
                            @endcan

                            @can('delete', $joke)
        {{-- Add Delete button here --}}
        <form method="POST" action="{{ route('jokes.destroy', $joke) }}" class="inline" onsubmit="return confirm('Are you sure you want to move this joke to trash?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="px-4 py-2 bg-red-600 text-white border border-transparent rounded-md hover:bg-red-700 transition ease-in-out duration-150 text-sm font-medium">
                <i class="fa-solid fa-trash mr-1"></i>
                {{ __('Delete') }}
            </button>
        </form>
    @endcan
</div>


                    </section>
                </article>
            </div>
        </div>
    </div>
</x-app-layout>
