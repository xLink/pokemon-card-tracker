<template>
  <Layout title="Dashboard">
    <div class="flex">
      <div class="flex flex-col w-4/6 p-2 gap-2">
        <template v-if="$page.props.latestCards.length">
          <h2 class="text-lg font-semibold">10 Random Cards</h2>          
          <div class="flex">
            <Card 
              v-for="card in $page.props.latestCards.slice(0, 5)" 
              :key="card.id" 
              :card="card"
            />
          </div>
          <div class="flex">
            <Card 
              v-for="card in $page.props.latestCards.slice(5, 10)"
              :key="card.id" 
              :card="card" 
            />
          </div>
        </template>
      </div>
      <div class="w-2/6">
        <div class="flex flex-col w-full">
          <div class="p-4">
            <h2 class="text-lg font-semibold">Total Sets</h2>
            <p class="text-3xl font-bold">{{ $page.props.activeSetCount }}</p>
          </div>
          <div class="p-4">
            <h2 class="text-lg font-semibold">Total Cards</h2>
            <p class="text-3xl font-bold">{{ $page.props.totalCardCount }}</p>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script>
export default {
  name: 'Dashboard',
}
</script>