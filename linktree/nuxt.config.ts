// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: "2024-04-03",
  devtools: { enabled: false },
  modules: [
    "@nuxt/ui",
    "@pinia/nuxt",
    "@pinia-plugin-persistedstate/nuxt",
    "nuxt-lodash",
  ],

  appConfig: {
    title: "LinkTree",
  },

  colorMode: {
    preference: "light",
  },

  runtimeConfig: {
    public: {
      API_URL: "http://localhost:8000",
    },
  },
});
