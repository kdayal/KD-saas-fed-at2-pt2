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
                            {{ __('Create New User') }}
                        </h5>
                    </header>

                    <section>

                        <form method="POST"
                              class="my-4 px-4 gap-4 flex flex-col text-gray-800"
                              action="{{ route('users.store') }}">

                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex flex-col">
                                    <x-input-label for="given_name" :value="__('Given Name')"/>
                                    <x-text-input id="given_name" class="block mt-1 w-full"
                                                  type="text" name="given_name" :value="old('given_name')" required
                                                  autofocus autocomplete="given-name"/>
                                    <x-input-error :messages="$errors->get('given_name')" class="mt-2"/>
                                </div>
                                <div class="flex flex-col">
                                    <x-input-label for="family_name" :value="__('Family Name')"/>
                                    <x-text-input id="family_name" class="block mt-1 w-full"
                                                  type="text" name="family_name" :value="old('family_name')" required
                                                  autocomplete="family-name"/>
                                    <x-input-error :messages="$errors->get('family_name')" class="mt-2"/>
                                </div>
                            </div>

                            <div class="flex flex-col">
                                <x-input-label for="Email" :value="__('Email')"/>
                                <x-text-input id="Email" class="block mt-1 w-full"
                                              type="email"
                                              name="email"
                                              :value="old('email')"
                                              required autofocus autocomplete="email"/>
                                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                            </div>

                            <div class="flex flex-col">
                                <x-input-label for="Password" :value="__('Password')"/>
                                <x-text-input id="Password" class="block mt-1 w-full"
                                              type="password"
                                              name="password"
                                              required autocomplete="new-password"/>
                                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                            </div>

                            <div class="flex flex-col">
                                <x-input-label for="Password_Confirmation" :value="__('Confirm Password')"/>
                                <x-text-input id="Password_Confirmation" class="block mt-1 w-full"
                                              type="password"
                                              name="password_confirmation"
                                              required autocomplete="new-password"/>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                            </div>


                            <div class="flex flex-col">
                                <x-input-label for="Role" :value="__('Role')"/>
                                <select id="role"
                                        class="block mt-1 w-full px-2 py-1 border-gray-300
                                            focus:outline-indigo-500 focus:outline-2 focus:ring-2 focus:ring-indigo-500
                                              rounded-md shadow-sm"
                                        name="role"
                                        required>
                                    <option value="" disabled selected>Select a role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>{{ $role }}</option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('role')" class="mt-2"/>
                            </div>


                            <div class="flex flex-row gap-6  ">

                                <a href="{{ route('users.index') }}"
                                   class="bg-gray-100 hover:bg-blue-500
                                          text-blue-800 hover:text-gray-100 text-center
                                          border border-gray-300
                                          transition ease-in-out duration-300
                                          p-2 min-w-24 rounded">
                                    <i class="fa-solid fa-times inline-block"></i>
                                    {{ __('Cancel') }}
                                </a>

                                <button type="submit"
                                        class="bg-gray-100 hover:bg-green-500
                                             text-green-800 hover:text-gray-100 text-center
                                             border border-gray-300
                                          transition ease-in-out duration-300
                                          p-2 min-w-32 rounded">
                                    <i class="fa-solid fa-save text-sm"></i>
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </form>

                    </section>

                </article>

            </div>
        </div>
    </div>
</x-app-layout>
