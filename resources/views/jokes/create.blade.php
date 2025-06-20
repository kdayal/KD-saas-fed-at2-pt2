<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            {{-- Link back to the jokes index page --}}
            <a href="{{ route('jokes.index') }}" class="grow">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Jokes') }}
                </h2>
            </a>
            {{-- Link to create another joke (optional, but consistent with user view) --}}
            <a href="{{ route('jokes.create') }}"
               class="text-green-800 hover:text-green-100
                     bg-gray-100 hover:bg-green-800
                     border border-gray-300
                     rounded-lg
                     transition ease-in-out duration-200
                     px-4 py-1">
                New Joke
                <i class="fa-solid fa-plus"></i> {{-- Changed icon --}}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <article class="my-0">

                    <header class="bg-gray-500 text-gray-50 text-lg px-4 py-2">
                        <h5>
                            {{ __('Create New Joke') }} {{-- Updated title --}}
                        </h5>
                    </header>

                    <section>

                        {{-- Form to store a new joke --}}
                        <form method="POST"
                              class="my-4 px-4 gap-4 flex flex-col text-gray-800"
                              action="{{ route('jokes.store') }}"> {{-- Updated form action --}}

                            @csrf

                            {{-- Joke Title Field --}}
                            <div class="flex flex-col">
                                <x-input-label for="title" :value="__('Title')"/> {{-- Updated label --}}
                                <x-text-input id="title" class="block mt-1 w-full"
                                              type="text"
                                              name="title"
                                              :value="old('title')"
                                              required autofocus/> {{-- Removed autocomplete as not standard for title --}}
                                <x-input-error :messages="$errors->get('title')" class="mt-2"/>
                            </div>

                            {{-- Joke Content Field --}}
                            <div class="flex flex-col">
                                <x-input-label for="body" :value="__('Content')"/> {{-- Changed label 'for' and name to 'body' --}}
                                <textarea id="body"
                                          name="body" {{-- Changed name to 'body' --}}
                                          rows="6" {{-- Adjust rows as needed --}}
                                          class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                          required>{{ old('body') }}</textarea> {{-- Changed old('content') to old('body') --}}
                                <x-input-error :messages="$errors->get('body')" class="mt-2"/> {{-- Changed error key to 'body' --}}
                            </div>

                            {{-- Categories Field --}}
                            <div class="flex flex-col mt-4">
                                <x-input-label for="categories" :value="__('Categories (Hold Ctrl/Cmd to select multiple)')"/>
                                <select name="categories[]" id="categories" multiple class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm h-32">
                                    @isset($categories) {{-- Ensure $categories variable exists --}}
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ (is_array(old('categories')) && in_array($category->id, old('categories'))) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                                <x-input-error :messages="$errors->get('categories')" class="mt-2"/>
                                <x-input-error :messages="$errors->get('categories.*')" class="mt-2"/> {{-- Individual category ID errors ke liye --}}
                            </div>


                            <div class="flex flex-row gap-6 mt-4"> {{-- Added mt-4 for spacing --}}

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

                                {{-- Save Button --}}
                                <button type="submit"
                                        class="bg-gray-100 hover:bg-green-500
                                             text-green-800 hover:text-gray-100 text-center
                                             border border-gray-300
                                          transition ease-in-out duration-300
                                          p-2 min-w-32 rounded">
                                    <i class="fa-solid fa-plus text-sm"></i> {{-- Changed icon --}}
                                    {{ __('Save Joke') }} {{-- Updated button text --}}
                                </button>
                            </div>
                        </form>

                    </section>

                </article>

            </div>
        </div>
    </div>
</x-app-layout>
