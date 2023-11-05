<template>
  <nav class="bg-gray-800">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="border-b border-gray-700">
        <div class="flex h-16 items-center justify-between px-4 sm:px-0">
          <div class="flex items-center">
            <div class="flex-shrink-0 text-white">
              PTCG Tracker
            </div>
            <div class="hidden md:block">
              <div v-if="nav_links.length > 0" class="ml-10 flex items-baseline space-x-4">
                <inertia-link 
                  v-for="link, idx in nav_links"
                  :key="idx"
                  :href="route(link.route)" 
                  class="px-3 py-2 text-sm font-medium cursor-pointer"
                  :class="{
                    'bg-gray-800 text-white rounded-md': (active === link.route),
                    'text-gray-300 hover:bg-gray-700 hover:text-white': !(active === link.route)
                  }"
                >
                  {{ link.name }}
                </inertia-link>
              </div>
            </div>
          </div>
          <div class="">
            <div class="ml-4 flex items-center md:ml-6 text-white">
              <NoAuth>
                <inertia-link 
                  :href="route('pages.login')" 
                  class="px-3 py-2 text-sm font-medium cursor-pointer"
                  :class="{
                    'bg-gray-800 text-white rounded-md': (active === 'pages.login'),
                    'text-gray-300 hover:bg-gray-700 hover:text-white': !(active === 'pages.login')
                  }"
                >
                  Login
                </inertia-link>
              </NoAuth>
              <NeedAuth>
                <span class="px-3 py-2 text-sm font-medium cursor-pointer">{{ user.name }}</span> - 
                <a :href="route('pages.logout')" onclick="javascript:document.getElementById('logout-form').submit();return false;" class="px-3 py-2 text-sm font-medium cursor-pointer hover:bg-gray-700">Logout</a>
                <form id="logout-form" :action="route('pages.logout')" method="POST" style="display: none;">
                  <csrf />
                </form>
              </NeedAuth>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'Navigation',

  data() {
    return {
      user: {},
      active: null,
      nav_links: [
        {
          name: 'Dashboard',
          route: 'pages.dashboard',
        },
        {          
          name: 'Sets',
          route: 'pages.sets.all',
        },
        {          
          name: 'Random Cards',
          route: 'pages.cards.random',
        },
      ]
    }
  },

  created() {
    this.user = this.$page.props.auth.user;
  }
}
</script>