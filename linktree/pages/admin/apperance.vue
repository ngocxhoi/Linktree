<template>
  <AdminLayout>
    <div id="ApperancePage" class="flex h-[calc(100%-50px)] pb-4">
      <div
        class="lg:w-[calc(100%-500px)] md:w-[calc(100%-330px)] w-full md:pt-20 pt-14"
      >
        <div class="max-w-[750px] mx-auto pb-24">
          <div id="ProfileSection">
            <div
              class="font-semibold pb-4"
              :class="isMobile ? 'mt-8 text-2xl' : 'mt-20 md:mt-8 text-xl'"
            >
              Profile
            </div>

            <div class="w-full bg-white rounded-3xl p-6">
              <div class="flex items-center justify-between gap-4">
                <img class="rounded-full w-[90px]" :src="user.image" />

                <div class="w-full">
                  <button
                    @click="openCropper = true"
                    class="flex items-center justify-center w-full py-3 rounded-full text-white font-semibold bg-[#8228D9] hover:bg-[#6c21b3] mb-2"
                  >
                    Pick image
                  </button>
                </div>
              </div>

              <div class="mt-4">
                <TextInput
                  placeholder="Profile Title"
                  v-model:input="name"
                  inputType="text"
                  :max="25"
                  :error="errors?.name?.[0] ?? ''"
                />
              </div>

              <textarea
                v-model="bio"
                rows="4"
                maxlength="80"
                placeholder="Bio"
                @focus="isBioFocused = true"
                @blur="isBioFocused = false"
                :class="isBioFocused ? 'border-gray-900' : ''"
                class="w-full mt-4 bg-[#EFF0EB] text-gray-800 border-2 text-sm border-[#EFF0EB] rounded-xl py-3.5 px-3 placeholder-gray-500 resize-none focus:outline-none"
              ></textarea>
              <div
                class="flex items-center justify-end text-[#676B5F] text-[13px]"
              >
                {{ bioLengthComputed }}/80
              </div>
            </div>
          </div>

          <div id="ThemeSection">
            <div
              class="font-semibold pb-4"
              :class="isMobile ? 'mt-8 text-2xl' : 'mt-20 md:mt-8 text-xl'"
            >
              Themes
            </div>

            <div class="w-full bg-white rounded-3xl p-6">
              <div
                class="grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 grid-cols-2 gap-4"
              >
                <div v-for="item in colors">
                  <div
                    class="border-2 border-gray-500 rounded-lg aspect-[2/3] border-dashed cursor-pointer transition-all duration-150 ease-in"
                    :class="user.theme_id == item.id ? 'p-2' : 'p-0'"
                  >
                    <div
                      @click="updateTheme(item.id)"
                      class="relative rounded-xl h-full mx-auto"
                    >
                      <div
                        class="absolute left-0 top-0 h-full w-full z-0"
                        :class="item.color"
                      />
                      <div class="relative z-10 pt-9">
                        <div
                          class="rounded-full mx-auto w-12 h-12 bg-[#EFF0EA]/70"
                        />

                        <div
                          class="w-[calc(100%-20px)] mx-auto rounded-full h-6 mt-4 bg-[#EFF0EA]/70"
                        />
                        <div
                          class="w-[calc(100%-20px)] mx-auto rounded-full h-6 mt-1 bg-[#EFF0EA]/70"
                        />
                        <div
                          class="w-[calc(100%-20px)] mx-auto rounded-full h-6 mt-1 bg-[#EFF0EA]/70"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="text-center">{{ item.name }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <MobileSectionDisplay />

      <CropperModal
        v-if="openCropper"
        @data="setData"
        @close="openCropper = false"
      />
    </div>
  </AdminLayout>
</template>

<script lang="ts" setup>
import AdminLayout from "../../layouts/AdminLayout.vue";

const { $userStore } = useNuxtApp();
const { isMobile, colors, user } = storeToRefs($userStore);

let data = ref();
let errors = ref();
let name = ref("");
let bio = ref("");
let isBioFocused = ref(false);
let openCropper = ref(false);

const setData = (dt: any) => {
  data.value = dt;
};

onMounted(() => {
  name.value = user.value.name;
  bio.value = user.value.bio ?? "";
});

const updateTheme = async (themeId: number) => {
  try {
    let res = await useApiFetch("/api/themes", "PATCH", { theme_id: themeId });
    if (res?.error.value) throw res.error.value.data;
    user.value.theme_id = themeId;
    $userStore.getUserTheme();
  } catch (error) {
    console.log(error);
  }
};

const updateUserDetails = useDebounce(async () => {
  let credential = {
    name: name.value,
    bio: bio.value,
  };
  try {
    let res = await useApiFetch(
      `/api/users/${user.value.id}`,
      "PATCH",
      credential
    );
    if (res?.error.value) throw res.error.value.data;
    else {
      user.value.name = name.value;
      user.value.bio = bio.value;
    }
  } catch (error: any) {
    console.log(error);
    errors.value = error;
  }
}, 1000);

const bioLengthComputed = computed(() => {
  return !user.value.bio ? 0 : user.value.bio.length;
});

const updateUserImage = async () => {
  try {
    let res = await useApiFetch("/api/user-image", "POST", data.value);
    if (res?.error.value) throw res.error.value.data;
    user.value.image = res?.data.value.image;
  } catch (error) {
    alert(error);
    console.log(error);
  } finally {
    setTimeout(() => (openCropper.value = false), 300);
  }
};

watch(
  () => name.value,
  async () => await updateUserDetails()
);
watch(
  () => bio.value,
  async () => await updateUserDetails()
);
watch(
  () => data.value,
  async () => await updateUserImage()
);
</script>
