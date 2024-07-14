export default defineNuxtRouteMiddleware((to, from) => {
  const userStore = useMyAuthStore();

  if (!userStore.user.id) {
    if (to.path == "/" || to.path == "/register") return;
    return navigateTo("/");
  }

  if (to.path == "/dashboard" && userStore.user.email_verified_at) {
    return navigateTo("/admin");
  }

  if (!userStore.user.email_verified_at) {
    if (to.path == "/dashboard") return;
    return navigateTo("/dashboard");
  }
});
