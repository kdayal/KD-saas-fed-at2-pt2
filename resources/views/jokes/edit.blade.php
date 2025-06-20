<x-app-layout>

    <x-slot name="header">
        {{-- Link back to the jokes index page --}}
        <a href="{{ route('jokes.index') }}" class="grow">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Jokes') }}
            </h2>
        </a>
        {{-- Link to create a new joke --}}
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
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <article class="my-0">

                    <header class="bg-gray-500 text-gray-50 text-lg px-4 py-2">
                        <h5>
                            {{ __('Edit Joke') }} {{-- Updated title --}}
                        </h5>
                    </header>

                    <section>

                        {{-- Form to update an existing joke --}}
                        <form method="POST"
                              class="my-4 px-4 gap-4 flex flex-col text-gray-800"
                              action="{{ route('jokes.update', $joke) }}"> {{-- Updated form action and pass $joke --}}

                            @csrf
                            @method('PATCH') {{-- Or PUT, depending on your preference/convention --}}

                            {{-- Joke Title Field --}}
                            <div class="flex flex-col">
                                <x-input-label for="title" :value="__('Title')"/> {{-- Updated label --}}
                                <x-text-input id="title" class="block mt-1 w-full"
                                              type="text"
                                              name="title"
                                              :value="old('title', $joke->title)" {{-- Pre-fill with existing joke title --}}
                                              required autofocus/>
                                <x-input-error :messages="$errors->get('title')" class="mt-2"/>
                            </div>

                            {{-- Joke Content Field --}}
                            <div class="flex flex-col">
                                <x-input-label for="content" :value="__('Content')"/> {{-- Updated label --}}
                                <textarea id="content"
                                          name="content"
                                          rows="6"
                                          class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                          required>{{ old('content', $joke->content) }}</textarea> {{-- Pre-fill with existing joke content --}}
                                <x-input-error :messages="$errors->get('content')" class="mt-2"/>
                            </div>

                            {{-- Joke Category Field  --}}
                            <div class="flex flex-col mt-4">
                            <x-input-label for="categories" :value="__('Categories (Hold Ctrl/Cmd to select multiple)')"/>
                            <select name="categories[]" id="categories" multiple class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm h-32">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ (is_array(old('categories')) && in_array($category->id, old('categories'))) || (empty(old('categories')) && in_array($category->id, $jokeCategoryIds ?? [])) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('categories')" class="mt-2"/>
                            <x-input-error :messages="$errors->get('categories.*')" class="mt-2"/> 
                        </div>

                          <div class="flex flex-row gap-6">

                                {{-- Cancel Button --}}
                                <a href="{{ route('jokes.index') }}" {{-- Updated cancel link --}}
                                   class="bg-gray-100 hover:bg-blue-500
                                          text-blue-800 hover:text-gray-100 text-center
                                          border border-gray-300
                                          transition ease-in-out duration-300
                                          p-2 min-w-24 rounded">
                                    <i class="fa-solid fa-times inline-block"></i>
                                    {{ __('Cancel') }}
                                </a>

                                {{-- Update Button --}}
                                <button type="submit"
                                        class="bg-gray-100 hover:bg-green-500
                                             text-green-800 hover:text-gray-100 text-center
                                             border border-gray-300
                                          transition ease-in-out duration-300
                                          p-2 min-w-32 rounded">
                                    <i class="fa-solid fa-save text-sm"></i>
                                    {{ __('Update Joke') }} {{-- Updated button text --}}
                                </button>
                            </div>
                        </form>

                    </section>

                </article>

            </div>
        </div>
    </div>
</x-app-layout>
