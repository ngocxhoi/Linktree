<template>
  <p class="text-red-500">{{ user.email_verified_at }}</p>
  <div v-if="user.email_verified_at == null">
    <UCard>
      <template #header> Verify your email address </template>
      <div>
        <p>
          Please verify your email address by clicking the link sent to
          {{ user.email }}.
        </p>
        <p>
          If you didn't receive the email, please check your spam folder or
          request a new verification link.
        </p>
      </div>
      <template #footer>
        <UButton @click="resendVerificationEmail"
          >Resend verification email</UButton
        >
        <UButton
          label="Logout"
          color="red"
          :loading="isLogout"
          @click="logout()"
        />
      </template>
    </UCard>
  </div>

  <div v-else>
    <UCard>
      <template #header>Email verification status</template>
      <div>
        <p>Your email address has been verified.</p>
        <p>
          You can now use your account for all the features of this website.
        </p>
      </div>
      <template #footer>
        <UButton label="Go to home" @click="navigateTo('/')" />
      </template>
    </UCard>
  </div>
</template>

<script lang="ts" setup>
const { $userStore } = useNuxtApp();
const { user } = storeToRefs($userStore);

const isLogout = ref(false);

const resendVerificationEmail = () => {
  console.log("Resented verification email");
};

onMounted(async () => {
  try {
    let res = await useApiFetch("/api/user");
    if (res?.error.value) throw res.error.value.data;
    user.value = res?.data.value.user;
  } catch (error: any) {
    console.log(error);
  }
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
</script>
