<template>
  <Layout :title="title">
    <div class="flex flex-row">
      <div class="flex flex-col w-[20%] bg-stone-200 rounded-l">
        <ActiveSelector class="w-full" />
      </div>
      <div class="flex flex-col w-[80%]">
        <div class="flex flex-col p-2">
          <CardCompareList :set="set" :cards="cards" :user1="user1" :user2="user2" />
        </div>
      </div>
    </div>
  </Layout>
</template>

<script>
export default {
  name: 'CompareSetCards',
  props: ['title', 'set', 'cards', 'user1', 'user2'],
}
</script>