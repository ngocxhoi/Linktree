<template>
  <div id="AdminLayout" class="w-full fixed z-30">
    <div
      id="TopNav"
      v-if="!isMobile"
      class="w-full flex items-center justify-between md:pt-2.5 md:px-2.5"
    >
      <div
        class="flex items-center justify-between md:rounded-full md:shadow-sm px-2 md:pl-6 pl-4 py-[8px] bg-white w-full border-b"
      >
        <div class="flex items-center justify-start w-full max-w-[500px]">
          <NuxtLink to="/admin">
            <img src="/images/linktree-logo-icon.png" alt="" class="w-10" />
          </NuxtLink>

          <div v-for="link in links" class="lg:px-2 px-0 5 md:block hidden">
            <NuxtLink
              :to="link.url"
              class="flex items-center text-sm font-semibold px-1.5 py-3 rounded-lg hover:bg-gray-100"
            >
              <Icon
                :name="link.icon"
                class="mr-0.5"
                size="18"
                :color="$route.fullPath == link.url ? '#000000' : '#676b5f'"
              />
              <div
                :class="
                  $route.fullPath == link.url
                    ? 'text-[#000000]'
                    : 'text-[#676b5f]'
                "
              >
                {{ link.name }}
              </div>
            </NuxtLink>
          </div>
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
            <Icon name="mdi:lightning-bolt" class="mr-0.5" size="22" /> Upgrade
          </button>

          <button
            class="flex items-center font-semibold px-3 py-2 rounded-full border bg-gray-100"
          >
            <Icon name="mdi:upload" class="mr-0.5" size="22" /> Share
          </button>

          <button
            @click="!isTopNav ? openMenu('TopNav') : (isTopNav = false)"
            class="rounded-full md:block hidden"
          >
            <img :src="user.image" alt="" class="rounded-full min-w-10 w-10" />
          </button>
        </div>
      </div>

      <div
        v-if="isTopNav"
        class="absolute md:block hidden right-4 top-16 border shadow-[0_5px_15px_rgba(0,0,0,0.1)] bg-white w-full max-w-[300px] rounded-2xl"
      >
        <button
          @click="logout()"
          :disabled="isLogout"
          class="w-full flex items-center text-gray-600 text-[15px] p-3 hover:text-black"
        >
          <Icon name="mdi:logout" class="mr-6" size="22" /> Sign out
        </button>
      </div>
    </div>

    <div
      v-if="!isMobile"
      id="SecondaryTopNav"
      class="w-full md:hidden flex items-center justify-between md:pt-2.5 md:px-2.5"
    >
      <div
        class="flex items-center justify-between gap-4 shadow-sm bg-white w-full"
      >
        <div class="flex w-full">
          <div v-for="link in linksSecondaryNav" class="w-1/4">
            <NuxtLink
              :to="link.url"
              class="relative flex justify-center border-t-black text-sm w-full h-full font-semibold px-1.5 my-[1px] py-[1px] hover:bg-gray-100"
              :class="
                link.url == $route.fullPath ? 'border-b-2 border-b-black' : ''
              "
            >
              <button class="relative pt-[6px]">
                <Icon
                  v-if="link.icon"
                  :name="link.icon"
                  size="20"
                  :color="$route.fullPath == link.url ? '#000000' : '#676b5f'"
                />
                <img
                  v-else
                  :src="link.img"
                  alt=""
                  class="rounded-full min-w-[22px] w-[22px]"
                />
                <div
                  class="relative text-[13px] text-[#676b5f]"
                  :class="link?.img ? '-left-[5px]' : ''"
                >
                  <span
                    :class="
                      $route.fullPath == link.url
                        ? 'text-black'
                        : 'text-[#676b5f]'
                    "
                    >{{ link.name }}</span
                  >
                </div>
              </button>
            </NuxtLink>
          </div>
        </div>
      </div>
    </div>

    <div
      v-if="!isMobile"
      id="PreviewButton"
      class="fixed bottom-10 left-1/2 -translate-x-1/2 items-center justify-center"
    >
      <button
        @click="isPreviewOverlay = true"
        class="md:hidden flex items-center left-[17px] font-semibold px-5 py-2.5 bg-[#dfe2d9] rounded-full"
      >
        <Icon name="mdi:eye-outline" size="20" class="mr-2" /> Preview
      </button>
    </div>

    <div
      v-if="isMobile"
      id="TopNavMobile"
      class="fixed w-full flex items-center justify-between px-2.5 bg-[#f3f3f1]"
    >
      <div class="flex items-center justify-between w-full py-2">
        <div
          class="flex items-center justify-between w-full text-3xl font-bold max-w-[500px]"
        >
          {{ currentMobilePage() }}
        </div>
        <div class="flex items-center justify-between gap-3">
          <button
            class="flex items-center text-18px font-semibold px-3 py-2 rounded-full bg-gray-200"
          >
            Upgrade
            <Icon name="mdi:lightning-bolt" size="20" class="ml-1" />
          </button>

          <button
            class="flex items-center font-semibold px-3 py-2 rounded-full hover:bg-gray-200"
          >
            <Icon name="ph:share-network" class="mr-0.5" size="23" />
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="px-2.5 w-full z-0">
    <slot />
  </div>

  <div
    v-if="isMobile"
    id="BottomNav"
    class="fixed z-20 bottom-0 flex w-full bg-white shadow-[0_35px_60px_10px_rgba(0,0,0,0.4)]"
    :class="isMobile ? 'h-[70px]' : 'h-[60px]'"
  >
    <div class="flex w-full">
      <div v-for="link in linksMobile" class="w-1/5">
        <button
          class="relative flex justify-center text-sm w-full h-full font-semibold px-1.5 py-1 hover:bg-gray-100"
          :class="link.url == route.fullPath ? 'border-t-2 border-t-black' : ''"
        >
          <NuxtLink :to="link.url" class="relative h-[35px]">
            <Icon
              v-if="link.icon"
              :name="link.icon"
              class="mr-0.5 mt-[2px]"
              size="25"
              :color="route.fullPath == link.url ? '#000000' : '#676B5F'"
            />
            <img
              v-else
              class="rounded-full min-w-[25px] w-[25px] mt-[2px]"
              :src="link.img"
            />
            <div
              class="relative text-[13px]"
              :class="link.img ? '-left-[4px]' : ''"
            >
              <span
                :class="
                  route.fullPath == link.url
                    ? 'text-[#000000]'
                    : 'text-[#676B5F]'
                "
              >
                {{ link.name }}
              </span>
            </div>
          </NuxtLink>
        </button>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
const { $userStore } = useNuxtApp();
const { isMobile, user, isPreviewOverlay } = storeToRefs($userStore);
const route = useRoute();

let isTopNav = ref(false);
let windowWidth = ref(import.meta.client ? window.innerWidth : "");
let isSecondaryTopNav = ref(false);
let isLogout = ref(false);

onMounted(() => {
  window.addEventListener("resize", () => {
    windowWidth.value = window.innerWidth;
  });
});

const links = ref([
  { name: "Links", url: "/admin", icon: "i-heroicons-bars-3" },
  {
    name: "Apperance",
    url: "/admin/apperance",
    icon: "i-heroicons-building-office-2",
  },
  { name: "Analytics", url: "/", icon: "i-heroicons-chart-bar" },
  { name: "Settings", url: "/admin/settings", icon: "i-heroicons-cog-8-tooth" },
]);
const linksSecondaryNav = ref([
  { name: "Links", url: "/admin", icon: "i-heroicons-bars-3" },
  {
    name: "Apperance",
    url: "/admin/apperance",
    icon: "i-heroicons-building-office-2",
  },
  { name: "Analytics", url: "/admin/settings", icon: "i-heroicons-chart-bar" },
  {
    name: "More",
    url: "/admin/more",
    img: user.value.image,
  },
]);
const linksMobile = ref([
  {
    name: "Links",
    url: "/admin",
    icon: "icon-park-outline:hamburger-button",
  },
  {
    name: "Apperance",
    url: "/admin/apperance",
    icon: "fluent:shapes-48-regular",
  },
  {
    name: "Preview",
    url: "/admin/preview",
    icon: "icon-park-outline:preview-open",
  },
  {
    name: "Analytics",
    url: "/admin/settings",
    icon: "tabler:brand-google-analytics",
  },
  { name: "More", url: "/admin/more", img: user.value.image },
]);

const currentMobilePage = () => {
  switch (route.fullPath) {
    case "/admin":
      return "Links";
      break;
    case "/admin/apperance":
      return "Apperance";
      break;
    case "/admin/preview":
      return "Preview";
    case "/admin/more":
      return "More";
    default:
      return "Dashboard";
  }
};

const openMenu = (menuId: string) => {
  if (menuId == "TopNav") isTopNav.value = true;
  else if (menuId == "SecondaryTopNav") isSecondaryTopNav.value = true;
  else navigateTo("/admin/settings");
};

async function logout() {
  isLogout.value = true;
  try {
    let res = await useApiFetch("/logout", "POST");
    if (res?.error.value) throw res.error.value.data;
    navigateTo("/");
    isTopNav.value = false;
    $userStore.resetState();
  } catch (error: any) {
    console.log("Error: ", error?.message);
  } finally {
    isLogout.value = false;
  }
}

watch(
  () => windowWidth.value,
  () => {
    if (Number(windowWidth.value) <= 767) {
      isTopNav.value = false;
    }
  }
);
</script>
