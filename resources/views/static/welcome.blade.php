<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12 space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Random Joke Section --}}
            @isset($randomJoke)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-800 mb-2">A Joke for You!</h3>
                        <blockquote class="border-l-4 border-gray-300 pl-4 italic">
                            <p class="mb-2 whitespace-pre-wrap">"{{ $randomJoke->body }}"</p>
                            <footer class="text-sm text-gray-500 not-italic">- {{ $randomJoke->user->name ?? 'A witty user' }}</footer>
                        </blockquote>
                    </div>
                </div>
            @else
                {{-- Fallback content if no jokes are in the database --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <p>Welcome! It looks like our joke book is empty at the moment. Please check back later!</p>
                    </div>
                </div>
            @endisset

            {{-- Original Welcome Content --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 gap-6 flex flex-col">
                    <h2 class="text-3xl">"Retro" Blade Templates</h2>
                    <p>Using the Blade templates from Laravel 11, with a few tweaks to provide a base for blade based
                        applications without the new UI features.</p>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg grid grid-cols-1 md:grid-cols-2 gap-x-12">
                <div class="p-6 text-gray-900 gap-6 flex flex-col">
                    <h3 class="text-xl">Starter Template Includes:</h3>
                    <ul class="list-disc ml-8 space-y-2">
                        <li>Blade Templates circa Laravel 11</li>
                        <li>Navigation bar on guest and app layouts</li>
                        <li>Footer in guest and app layouts</li>
                        <li>Sample Users (Admin - Validated, Staff &amp; Client - not validated)</li>
                        <li><a href="https://laravel.com/docs/sanctum" target="_blank" rel="noopener noreferrer"
                               class="text-blue-700 underline underline-offset-3">
                                Sanctum authentication</a>
                            <i class="fa-solid fa-up-right-from-square text-gray-300 text-xs ml-1"></i></li>
                        <li>Email Verification enabled</li>
                        <li><a href="https://laraveldebugbar.com" target="_blank" rel="noopener noreferrer"
                               class="text-blue-700 underline underline-offset-3">
                                Laravel Debug Bar</a>
                            <i class="fa-solid fa-up-right-from-square text-gray-300 text-xs ml-1"></i></li>

                        <li><a href="https://laravel.com/docs/telescope" target="_blank" rel="noopener noreferrer"
                               class="text-blue-700 underline underline-offset-3">
                                Laravel Telescope</a>
                            <i class="fa-solid fa-up-right-from-square text-gray-300 text-xs ml-1"></i></li>

                        <li><a href="https://livewire.laravel.com" target="_blank" rel="noopener noreferrer"
                               class="text-blue-700 underline underline-offset-3">
                                Laravel Livewire</a>
                            <i class="fa-solid fa-up-right-from-square text-gray-300 text-xs ml-1"></i></li>

                        <li><a href="https://fontawesome.com" target="_blank" rel="noopener noreferrer"
                               class="text-blue-700 underline underline-offset-3">
                                Font Awesome 6 (Free)</a>
                            <i class="fa-solid fa-up-right-from-square text-gray-300 text-xs ml-1"></i></li>

                    </ul>
                </div>

                <div class="p-6 text-gray-900 gap-6 flex flex-col">
                    <h3 class="text-xl">Template Development</h3>
                    <dl class="">
                        <dt>Adrian Gould</dt>
                        <dd>Lecturer (ASL1), <a href="https://northmetrotafe.wa.edu.au" target="_blank" rel="noopener noreferrer"
                                                class="text-red-700 underline underline-offset-3">
                                North Metropolitan TAFE</a>
                            <i class="fa-solid fa-up-right-from-square text-gray-300 text-xs ml-1"></i>,
                            Perth WA, Australia
                        </dd>
                        <dd>GitHub Pages: <a href="https://adygcode.github.io" target="_blank" rel="noopener noreferrer"
                                             class="text-blue-700 underline underline-offset-3">
                                https://adygcode.github.io</a>
                            <i class="fa-solid fa-up-right-from-square text-gray-300 text-xs ml-1"></i></dd>
                        <dd>GitHub Repos: <a href="https://github.com/AdyGCode" target="_blank" rel="noopener noreferrer"
                                             class="text-blue-700 underline underline-offset-3">
                                https://github.com/AdyGCode</a>
                            <i class="fa-solid fa-up-right-from-square text-gray-300 text-xs ml-1"></i></dd>
                        <dd>Starter Kit Repo: <a href="https://github.com/AdyGCode/retro-blade-kit" target="_blank" rel="noopener noreferrer"
                                                 class="text-blue-700 underline underline-offset-3">
                                Retro Blade Starter Kit</a>
                            <i class="fa-solid fa-up-right-from-square text-gray-300 text-xs ml-1"></i></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
