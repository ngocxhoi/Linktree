<template>
  <div id="AuthLayout" class="h-screen w-full flex justify-between">
    <div class="lg:pt-7 pt-3 lg:px-12 px-6 lg:w-2/3 w-full lg:min-w-[800px]">
      <NuxtLink to="/" class="inline-block w-40">
        <img alt="Linktree logo" src="/images/linktree-logo.png" />
      </NuxtLink>

      <main class="w-full">
        <div class="w-full md:max-w-[550px] max-w-[360px] mx-auto">
          <slot />
        </div>
      </main>
    </div>

    <div class="lg:block hidden w-1/3 pointer-events-none">
      <img
        v-if="$route.fullPath == '/'"
        src="/images/side1.png"
        alt=""
        class="object-cover w-full h-screen select-none"
      />
      <img
        v-else
        src="/images/side2.png"
        alt=""
        class="object-cover w-full h-screen select-none"
      />
    </div>
  </div>
</template>

<script lang="ts" setup>
const { $userStore } = useNuxtApp();
const { updatedLinkId } = storeToRefs($userStore);

// onMounted(() => {
//   updatedLinkId.value = 0;
// });
</script>
