<template>
  <div
    id="AddLinkOverlay"
    class="fixed z-40 top-0 left-0 w-full h-full bg-white px-5"
  >
    <div class="flex items-center justify-start w-full py-[8px]">
      <button type="button" @click="close()" class="rounded-full">
        <Icon
          name="material-symbols:arrow-back-sharp"
          size="35"
          color="#676B5F"
        />
      </button>

      <div class="text-lg font-semibold pl-8">Add New Link</div>
    </div>

    <div class="text-2xl font-semibold pt-10">Enter URL</div>

    <form
      @submit.prevent="addLink()"
      class="flex items-center gap-4 w-full pt-4"
    >
      <div class="w-full">
        <TextInput
          class="w-full"
          placeholder="Name"
          v-model:input="name"
          inputType="text"
          :error="errors?.name?.[0] ?? ''"
        />

        <div class="py-1" />

        <TextInput
          class="w-full"
          placeholder="URL"
          v-model:input="url"
          inputType="text"
          :error="errors?.url?.[0] ?? ''"
        />
      </div>

      <button
        :disabled="isLoading"
        type="submit"
        class="rounded-full p-2 bg-[#EFF0EA]"
      >
        <Icon
          name="material-symbols:arrow-forward-sharp"
          size="25"
          color="#676B5F"
        />
      </button>
    </form>
  </div>
</template>

<script lang="ts" setup>
const { $userStore } = useNuxtApp();
const { addLinkOverlay, allLinks } = storeToRefs($userStore);

onMounted(() => $userStore.hidePageOverflow(true, "AdminPage"));

const close = () => (addLinkOverlay.value = false);

let name = ref("");
let url = ref("");
let errors = ref();
let isLoading = ref(false);

const addLink = async () => {
  const credential = {
    name: name.value,
    url: url.value,
  };
  try {
    isLoading.value = true;
    let res = await useApiFetch(`/api/link`, "POST", credential);
    if (res?.error.value) throw res.error.value.data;
    else {
      allLinks.value.push(res?.data.value.link);
    }
  } catch (error) {
    console.log(error);
    errors.value = error;
  } finally {
    isLoading.value = false;
    setTimeout(() => {
      name.value = "";
      url.value = "";
      addLinkOverlay.value = false;
    }, 100);
  }
};

onUnmounted(() => {
  $userStore.hidePageOverflow(false, "AdminPage");
  addLinkOverlay.value = false;
});
</script>
