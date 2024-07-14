<template>
  <AuthLayout>
    <div class="mt-10">
      <h1 class="lg:text-4xl text-3xl text-center font-bold">
        Log in to your Linktree
      </h1>

      <form class="mt-12" @submit.prevent="login()">
        <div>
          <TextInput
            placeholder="Email:ex@example.com"
            v-model:input="credentials.email"
            inputType="email"
            :error="errors?.email?.[0] ?? ''"
          />
        </div>
        <div class="mt-4">
          <TextInput
            placeholder="Password"
            v-model:input="credentials.password"
            inputType="password"
            :error="errors?.password?.[0] ?? ''"
          />
        </div>
        <div class="mt-10">
          <button
            type="submit"
            class="rounded-full w-full font-semibold py-2"
            :disabled="!credentials.email || !credentials.password || isLoading"
            :class="
              credentials.email && credentials.password && !isLoading
                ? 'bg-[#8228d9] hover:bg-[#6c21b3] text-white'
                : 'bg-[#eff0eb] text-[#a7aaa2]'
            "
          >
            Log in
          </button>
        </div>
      </form>

      <div class="text-base text-center mt-12">
        Don't have an account?
        <NuxtLink to="/register" class="text-[#8228d9] underline">
          Sign up now
        </NuxtLink>
      </div>
    </div>
  </AuthLayout>
</template>

<script lang="ts" setup>
import AuthLayout from "~/layouts/AuthLayout.vue";
definePageMeta({
  middleware: "is-auth",
});

const { $userStore } = useNuxtApp();
const { user, token } = storeToRefs($userStore);

const credentials = reactive({
  email: "",
  password: "",
});
const errors = ref();
const isLoading = ref(false);

async function login() {
  console.log("clicked");
  errors.value = null;
  isLoading.value = true;
  try {
    let res = await useApiFetch("/login", "POST", credentials);
    if (res?.error.value) throw res.error.value.data;

    user.value = res?.data.value.user;
    token.value = res?.data.value.token;
    navigateTo("/admin");
  } catch (error: any) {
    console.log("Error: ", error?.message);
    errors.value = error?.errors;
  } finally {
    isLoading.value = false;
  }
}
</script>
