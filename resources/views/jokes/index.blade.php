<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Jokes') }}
            </h2>
            <div>
                <a href="{{ route('jokes.trash') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                    <i class="fa-solid fa-trash-can mr-1"></i>{{ __('View Trash') }}
                </a>
                <a href="{{ route('jokes.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fa-solid fa-plus mr-1"></i>{{ __('New Joke') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Search Form --}}
            <div class="mb-4">
                {{-- Aapka search form yahan pehle se hai, use waise hi rehne dein --}}
                <form method="GET" action="{{ route('jokes.index') }}">
                    <div class="flex">
                        <input type="text" name="search_term" placeholder="Search jokes by keyword..."
                               value="{{ request('search_term') }}"
                               class="w-full md:w-1/2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                        <select name="category_search" class="ml-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_search') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                                class="ml-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Search') }}
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Title
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Category
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Author
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Created
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"> {{-- Actions header ko text-right kiya --}}
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($jokes as $joke)
                                    <tr>
                                        {{-- Column 1: Title, Body, Like/Dislike --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ Str::limit($joke->title, 40) }}</div>
                                            <div class="text-xs text-gray-500">{{ Str::limit($joke->body, 60) }}</div>
                                            <div class="mt-2 flex items-center space-x-4">
                                                {{-- Like Button --}}
                                                <form action="{{ route('jokes.interact', $joke) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="interaction_type" value="like">
                                                    <button type="submit"
                                                            class="flex items-center text-sm {{ $joke->isLikedByAuthUser() ? 'text-blue-600 font-semibold' : 'text-gray-500 hover:text-blue-600' }}">
                                                        <i class="fa-solid fa-thumbs-up mr-1"></i>
                                                        <span>{{ $joke->likesCount() }}</span>
                                                    </button>
                                                </form>
                                                {{-- Dislike Button --}}
                                                <form action="{{ route('jokes.interact', $joke) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="interaction_type" value="dislike">
                                                    <button type="submit"
                                                            class="flex items-center text-sm {{ $joke->isDislikedByAuthUser() ? 'text-red-600 font-semibold' : 'text-gray-500 hover:text-red-600' }}">
                                                        <i class="fa-solid fa-thumbs-down mr-1"></i>
                                                        <span>{{ $joke->dislikesCount() }}</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        {{-- Column 2: Category --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @forelse($joke->categories as $category)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800 mr-1 mb-1">
                                                    {{ $category->name }}
                                                </span>
                                            @empty
                                                N/A
                                            @endforelse
                                        </td>
                                        {{-- Column 3: Author --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $joke->user->name ?? 'Unknown' }}
                                        </td>
                                        {{-- Column 4: Created Date --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $joke->created_at->format('M d, Y') }}
                                        </td>
                                        {{-- Column 5: Actions --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                            <a href="{{ route('jokes.show', $joke) }}" class="text-indigo-600 hover:text-indigo-900" title="View"><i class="fa-solid fa-eye"></i></a>
                                            @can('update', $joke)
                                                <a href="{{ route('jokes.edit', $joke) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit"><i class="fa-solid fa-edit"></i></a>
                                            @endcan
                                            @can('delete', $joke)
                                                <form action="{{ route('jokes.destroy', $joke) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to move this joke to trash?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No jokes found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($jokes->hasPages())
                        <div class="mt-4 p-2">
                            {{ $jokes->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
