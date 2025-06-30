<footer class="mt-4  p-4 md:p-8
             bg-gray-900 dark:bg-gray-950
             text-gray-300 dark:text-gray-400
               text-sm
               grid grid-cols-1 md:grid-cols-2 gap-2">
    <section class="">
        <p>&copy; Copyright 2024 Khushboo Dayal. All rights reserved.</p>
    </section>
    <section class="grid grid-cols-2 gap-4">
        <nav class="flex flex-col gap-1">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a>
            <a href="{{ route('about') }}" class="hover:text-white">About</a>
            <a href="{{ route('contact-us') }}" class="hover:text-white">Contact Us</a>
            <a href="{{ route('privacy') }}" class="hover:text-white">Privacy</a>
        </nav>
        <nav class="flex flex-col gap-1">
            <a href="{{ route('pricing') }}" class="hover:text-white">Pricing</a>
            <a href="#" class="hover:text-white">Terms of Service</a>
        </nav>
    </section>
</footer>
