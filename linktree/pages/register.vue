<template>
  <AuthLayout>
    <div class="mt-10">
      <h1 class="lg:text-4xl text-3xl text-center font-bold">
        Create your Linktree
      </h1>

      <form class="mt-12" @submit.prevent="register()">
        <div>
          <TextInput
            placeholder="Username"
            v-model:input="credentials.name"
            inputType="text"
            :error="errors?.name?.[0] ?? ''"
          />
        </div>
        <div class="mt-4">
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
        <div class="mt-4">
          <TextInput
            placeholder="Confirm Password"
            v-model:input="credentials.password_confirmation"
            inputType="password"
          />
        </div>
        <div class="mt-10">
          <button
            type="submit"
            class="rounded-full w-full font-semibold py-2"
            :disabled="Boolean(!buttonDisabled) || isLoading"
            :class="
              buttonDisabled && !isLoading
                ? 'bg-[#8228d9] hover:bg-[#6c21b3] text-white'
                : 'bg-[#eff0eb] text-[#a7aaa2]'
            "
          >
            Sign up
          </button>
        </div>
      </form>

      <div class="text-base text-center mt-12">
        Already have an account?
        <NuxtLink to="/" class="text-[#8228d9] underline">
          Log in now
        </NuxtLink>
      </div>
    </div>
  </AuthLayout>
</template>

<script lang="ts" setup>
import { useApiFetch } from "~/composables/ApiFetch";
import AuthLayout from "~/layouts/AuthLayout.vue";
definePageMeta({
  middleware: "is-auth",
});

const { $userStore } = useNuxtApp();
const { user, token } = storeToRefs($userStore);

const credentials = reactive({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});
const isLoading = ref(false);
const errors = ref();
const buttonDisabled = computed(
  () =>
    credentials.name &&
    credentials.email &&
    credentials.password &&
    credentials.password_confirmation
);
async function register() {
  errors.value = null;
  isLoading.value = true;
  try {
    let res = await useApiFetch("/register", "POST", credentials);
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
