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
              @include('components.navlink', ['route' => 'pages.dashboard', 'slot' => 'Dashboard'])
              @include('components.navlink', ['route' => 'pages.sets.all', 'slot' => 'Sets'])
              @include('components.navlink', ['route' => 'pages.cards.random', 'slot' => 'Random Cards'])
            </div>
          </div>
        </div>
        <div class="">
          <div class="ml-4 flex items-center md:ml-6 text-white">
            @auth
            {{ auth()->user()->name }} - 
            @include('components.navlink', ['route' => 'pages.logout', 'slot' => 'Logout'])
            @else
            @include('components.navlink', ['route' => 'pages.login', 'slot' => 'Login'])
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>