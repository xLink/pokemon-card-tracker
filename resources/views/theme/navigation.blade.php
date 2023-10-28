<nav class="bg-gray-800">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="border-b border-gray-700">
        <div class="flex h-16 items-center justify-between px-4 sm:px-0">
            <div class="flex items-center">
            <div class="flex-shrink-0 text-white">
                Track Your PTCG Collection
            </div>
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4">
                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                <a href="/" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Dashboard</a>
                <a href="{{ route('pages.cards') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Cards</a>
                <a href="{{ route('pages.sets') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Sets</a>
                <a href="{{ route('pages.decks') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Decks</a>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</nav>