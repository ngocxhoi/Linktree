<template>
  <div
    id="PreviewOverlay"
    class="md:hidden fixed z-30 top-0 left-0 h-full w-full overflow-auto"
    :class="theme.color"
  >
    <div
      id="PreviewOverlayTopNav"
      class="w-full fixed z-10 flex items-center justify-between"
    >
      <div
        class="flex items-center justify-between px-2 py-[8px] pl-4 bg-white w-full border-b"
      >
        <div class="flex items-center justify-start w-full">
          <button @click="isPreviewOverlay = false">
            <img
              class="w-[23px] min-w-[23px] select-none"
              src="/images/linktree-logo-icon.png"
            />
          </button>
        </div>

        <div class="flex items-center justify-between gap-3">
          <button
            class="flex items-center text-sm font-semibold p-2 rounded-full hover:bg-gray-100"
          >
            <Icon
              name="healthicons:megaphone-outline"
              class="mr-0.5"
              size="22"
            />
          </button>

          <button
            class="flex items-center font-semibold px-3 py-2 rounded-full bg-gray-100"
          >
            <Icon name="mdi:lightning-bolt" class="mr-0.5" size="18" />
            Upgrade
          </button>

          <button
            class="flex items-center font-semibold px-3 py-2 rounded-full border hover:bg-gray-100"
          >
            <Icon name="teenyicons:upload-solid" class="mr-1.5" size="18" />
            Share
          </button>
        </div>
      </div>
    </div>

    <div
      id="PreviewOverlayContentSection"
      class="relative w-full h-full mx-auto pt-24"
    >
      <div class="mx-auto mb-16 w-full p-3">
        <div class="h-full mx-auto w-full overflow-auto z-10">
          <img
            class="rounded-full min-w-[100px] w-[100px] mx-auto"
            :src="user.image"
          />

          <div
            class="text-center text-xl font-semibold mt-4"
            :class="theme.text"
          >
            @{{ $userStore.allLowerCaseNoCaps(user.name) }}
          </div>

          <div class="text-center font-light mt-2" :class="theme.text">
            <div class="px-8">
              {{ user.bio }}
            </div>
          </div>

          <div v-if="allLinks.length > 0" v-for="link in allLinks">
            <a
              :href="link.url"
              target="_blank"
              class="flex items-center relative border w-[calc(100%-10px)] mx-auto bg-white mt-4 p-1 rounded-lg"
            >
              <img
                class="rounded-lg h-[45px] aspect-square"
                :src="link.image"
              />

              <div class="absolute text-[16px] text-center w-full">
                {{ link.name }}
              </div>
            </a>
          </div>
          <div class="pb-28" />
        </div>
      </div>
    </div>

    <div
      id="PreviewButton"
      class="fixed bottom-10 w-full flex items-center justify-center"
    >
      <button
        @click="isPreviewOverlay = false"
        class="flex items-center justify-center p-2.5 bg-[#DFE2D9] rounded-full"
      >
        <Icon name="mdi:close" size="30" />
      </button>
    </div>
  </div>
</template>

<script lang="ts" setup>
const { $userStore } = useNuxtApp();
const { isPreviewOverlay, theme, allLinks, user } = storeToRefs($userStore);

onUnmounted(() => (isPreviewOverlay.value = false));
</script>
