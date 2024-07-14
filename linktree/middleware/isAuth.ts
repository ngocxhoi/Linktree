export default defineNuxtRouteMiddleware((to, from) => {
  const userStore = useMyAuthStore();

  if (to.fullPath === "/" && userStore.user.id) {
    return navigateTo("/admin");
  }

  if (to.fullPath === "/register" && userStore.user.id) {
    return navigateTo("/admin");
  }
});
