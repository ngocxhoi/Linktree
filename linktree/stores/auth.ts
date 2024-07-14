import { defineStore } from "pinia";
import { useApiFetch } from "~/composables/ApiFetch";

interface AllLink {
  id: number;
  name: string;
  url: string;
  image: string;
}

interface Colors {
  id: number;
  color: string;
  text: string;
  name: string;
}

interface User {
  id: string;
  email: string;
  name: string;
  bio: string | null;
  theme_id: number;
  image: string;
  email_verified_at: string | null;
}

export const useMyAuthStore = defineStore({
  id: "myAuthStore",
  state: () => ({
    user: {} as User,
    token: "",
    name: "Username",
    theme: {} as Colors,
    colors: [] as Colors[],
    allLinks: [] as AllLink[],
    isMobile: false,
    updatedLinkId: 0,
    addLinkOverlay: false,
    isPreviewOverlay: false,
  }),

  actions: {
    hidePageOverflow(val: boolean, id: string) {
      const getElement = document.getElementById(id);
      if (getElement) {
        if (val) {
          document.body.style.overflow = "hidden";
          if (id) {
            getElement.style.overflow = "hidden";
          }
          return;
        }
        document.body.style.overflow = "visible";
        if (id) {
          getElement.style.overflow = "visible";
        }
      }
    },

    allLowerCaseNoCaps(str: string) {
      return str.split(" ").join("_").toLowerCase();
    },

    getUserTheme() {
      this.colors.forEach((color: Colors) => {
        if (this.user.theme_id === color.id) {
          this.theme = color;
          return this.theme;
        }
      });
    },

    resetState() {
      this.user = {} as User;
      this.token = "";
      this.name = "Username";
      this.theme = {} as Colors;
      this.colors = [] as Colors[];
      this.allLinks = [] as AllLink[];
      this.isMobile = false;
      this.updatedLinkId = 0;
      this.addLinkOverlay = false;
      this.isPreviewOverlay = false;
    },
  },
  persist: true,
});
