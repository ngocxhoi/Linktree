<template>
  <NuxtRouteAnnouncer />
  <div :class="{ 'bg-[#f3f3f1]': bgIsGray }">
    <NuxtLayout>
      <NuxtPage />
    </NuxtLayout>
  </div>
  <UpdateLinkOverlay v-if="isMobile && updatedLinkId" />
  <AddLinkOverlay v-if="isMobile && addLinkOverlay" />
  <PreviewOverlay v-if="!isMobile && isPreviewOverlay" />
</template>

<script lang="ts" setup>
const appConfig = useAppConfig();

useHead({
  titleTemplate(title): any {
    return title ? `${title} | ${appConfig.title}` : appConfig.title;
  },
});

const { $userStore } = useNuxtApp();
const {
  isMobile,
  isPreviewOverlay,
  updatedLinkId,
  addLinkOverlay,
  colors,
  allLinks,
} = storeToRefs($userStore);

const route = useRoute();
let bgIsGray = ref(true);

onMounted(() => {
  colors.value = setColors();
  $userStore.getUserTheme();
  updatedLinkId.value = 0;
  addLinkOverlay.value = false;
  isPreviewOverlay.value = false;
  isMobile.value = false;

  checkPath(route.fullPath);

  if ("ontouchstart" in window) {
    isMobile.value = true;
  }
});

function setColors() {
  return [
    { id: 1, color: "bg-white", text: "text-black", name: "Air White" },
    { id: 2, color: "bg-gray-800", text: "text-white", name: "Lake Black" },
    {
      id: 3,
      color: "bg-gradient-to-t from-indigo-500 via-purple-500 to-pink-500",
      text: "text-white",
      name: "Purple Pie",
    },
    {
      id: 4,
      color: "bg-gradient-to-t from-gray-500 via-blue-500 to-green-500",
      text: "text-white",
      name: "Green Grass",
    },
    {
      id: 5,
      color: "bg-gradient-to-t from-orange-500 via-green-500 to-red-500",
      text: "text-white",
      name: "Traffic Lights",
    },
    {
      id: 6,
      color: "bg-gradient-to-b from-blue-800 via-blue-500 to-green-500",
      text: "text-white",
      name: "Blue Sky",
    },
    {
      id: 7,
      color: "bg-gradient-to-t from-lime-500 via-indigo-700 to-amber-500",
      text: "text-white",
      name: "Soft Horizon",
    },
    {
      id: 8,
      color: "bg-gradient-to-t from-gray-800 to-emerald-500",
      text: "text-white",
      name: "Tinted Lake",
    },
  ];
}

const checkPath = (path: string) => {
  if (path == "/" || path == "/register") {
    bgIsGray.value = false;
    return;
  }
};

watch(
  () => route.fullPath,
  (path) => checkPath(path)
);

watch(
  () => isPreviewOverlay.value,
  (val) => {
    let id = "";
    if (route.fullPath == "/admin") id = "AdminPage";
    else if (route.fullPath == "/admin/apperence") id = "ApperencePage";
    else if (route.fullPath == "/admin/settings") id = "SettingsPage";

    $userStore.hidePageOverflow(val, id);
  }
);
</script>
