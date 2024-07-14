<template>
  <AdminLayout>
    <div id="MorePage" class="flex" :class="isMobile ? 'pt-24' : 'pt-32'">
      <div class="rounded-md bg-white w-full">
        <button
          @click="logout()"
          :disabled="isLogout"
          class="w-full flex items-center text-gray-600 p-3 hover:text-black"
          :class="isMobile ? 'text-[20px]' : 'text-[15px]'"
        >
          <Icon
            name="circum:logout"
            class="mr-6"
            :size="isMobile ? '22' : '15'"
          />
          Sign out
        </button>
      </div>
    </div>
  </AdminLayout>
</template>

<script lang="ts" setup>
import AdminLayout from "../../layouts/AdminLayout.vue";

const { $userStore } = useNuxtApp();
const { isMobile } = storeToRefs($userStore);
const router = useRouter();

let windowWidth = ref(import.meta.client ? window.innerWidth : "");
const isLogout = ref(false);

onMounted(() => {
  window.addEventListener("resize", function () {
    windowWidth.value = window.innerWidth;
  });
});

async function logout() {
  isLogout.value = true;
  try {
    let res = await useApiFetch("/logout", "POST");
    if (res?.error.value) throw res.error.value.data;
    navigateTo("/");
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
    if (Number(windowWidth.value) >= 767) {
      router.push("/admin");
    }
  }
);
</script>
