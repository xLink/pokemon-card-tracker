<div class="min-h-full">
    <div class="bg-gray-800 pb-32">
        @include('theme.navigation')
        <header class="py-10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-white">@yield('header')</h1>
            </div>
        </header>
    </div>

    <main class="-mt-32">
        <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white px-5 py-6 shadow">
                @yield('content')
            </div>
        </div>
    </main>
</div>