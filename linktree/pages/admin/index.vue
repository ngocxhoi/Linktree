<template>
  <AdminLayout>
    <div id="AdminPage" class="flex h-screen pb-4">
      <div
        class="lg:w-[calc(100%-500px)] md:w-[calc(100%-330px)] w-full md:pt-20 pt-14 overflow-y-auto custom-scroll"
      >
        <div class="max-w-[750px] mx-auto pb-24">
          <button
            v-if="!isMobile || !showAddLink"
            @click="showAddLinkFunc()"
            class="flex items-center justify-center w-full py-3 rounded-full text-white font-semibold bg-[#8228D9] hover:bg-[#6c21b3]"
            :class="isMobile ? 'mt-8 text-xl' : 'mt-20 md:mt-8'"
          >
            <Icon v-if="!isMobile" name="mdi:plus" class="mr-0.5" size="25" />
            <span v-if="!isMobile">Add link</span>
            <span v-if="isMobile">Add new link</span>
          </button>

          <AddLink
            v-if="!isMobile"
            @close="showAddLink = false"
            :class="[
              {
                'mt-20 md:mt-8 mb-12 max-h-[1000px] transition-all duration-300 ease-in':
                  showAddLink,
              },
              { 'max-h-0 transition-all duration-300 ease-out': !showAddLink },
            ]"
          />

          <div
            v-if="allLinks?.length > 0"
            v-for="link in allLinks"
            class="mt-4"
          >
            <LinkBox
              :link="link"
              :selectedId="selectedInput.id"
              :selectedStr="selectedInput.str"
              @updatedInput="updatedInput"
              class="mt-6"
            />
          </div>
        </div>
      </div>

      <MobileSectionDisplay />
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from "../../layouts/AdminLayout.vue";

const { $userStore } = useNuxtApp();
const { isMobile, addLinkOverlay, allLinks } = storeToRefs($userStore);

onMounted(async () => {
  try {
    let res = await useApiFetch("/api/links");
    if (res?.error.value) throw res.error.value.data;
    allLinks.value = res?.data.value?.links;
  } catch (error) {
    console.log(error);
  }
});

let selectedInput = ref({ id: 0, str: "" });
let showAddLink = ref(false);

const updatedInput = (e: { id: number; str: string }) => {
  selectedInput.value.id = e.id;
  selectedInput.value.str = e.str;
};

const showAddLinkFunc = () => {
  if (isMobile.value) {
    addLinkOverlay.value = true;
  } else {
    showAddLink.value = true;
  }
};
</script>

<style scoped>
/* width */
.custom-scroll::-webkit-scrollbar {
  width: 0px;
}

/* Track */
.custom-scroll::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
.custom-scroll::-webkit-scrollbar-thumb {
  background: #888;
}

/* Handle on hover */
.custom-scroll::-webkit-scrollbar-thumb:hover {
  background: #555;
}
</style>
