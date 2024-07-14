<template>
  <div class="fixed overflow-auto w-full h-screen" :class="theme.color" />

  <AdminLayout>
    <div id="PreviewAdminPage" class="w-full mx-auto pt-32 relative z-10">
      <div class="mx-auto w-full">
        <div class="h-full mx-auto w-full">
          <img
            class="rounded-full min-w-[120px] w-[120px] mx-auto"
            :src="user.image"
          />

          <div
            class="text-center text-2xl font-semibold mt-2"
            :class="theme.text"
          >
            @{{ $userStore.allLowerCaseNoCaps(user.name) }}
          </div>

          <div
            class="text-center text-lg font-light mt-2 mb-10"
            :class="theme.text"
          >
            <div class="px-8">
              {{ user.bio }}
            </div>
          </div>

          <div v-for="link in allLinks">
            <a
              :href="link.url"
              target="_blank"
              class="flex items-center relative border w-[calc(100%-10px)] md:w-[calc(100%-100px)] mx-auto bg-white mt-4 p-1 rounded-lg"
            >
              <img
                class="rounded-lg h-[55px] aspect-square"
                :src="link.image"
              />

              <div class="absolute text-[20px] text-center w-full">
                {{ link.name }}
              </div>
            </a>
          </div>

          <div class="pb-32" />
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script lang="ts" setup>
import AdminLayout from "../../layouts/AdminLayout.vue";

const { $userStore } = useNuxtApp();
const { allLinks, user, theme } = storeToRefs($userStore);
</script>
