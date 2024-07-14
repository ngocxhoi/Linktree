export default defineNuxtPlugin((nuxtApp) => {
  return {
    provide: {
      userStore: useMyAuthStore(),
      // globalStore: useMyGlobalStore(),
    },
  };
});
