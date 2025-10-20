import { defineStore } from "pinia";
import api from "../js/api";

export const useUserStore = defineStore("user", {
  state: () => ({
    user: null,
  }),
  getters: {
    isAuthenticated: (state) => !!state.user,
  },
  actions: {
    async fetchUser() {
      try {
        const res = await api.get("/user");
        this.user = res.data;
      } catch (error) {
        console.error("Fetch user failed:", error);
      }
    },
    setUser(user) {
      this.user = user;
    },
    clearUser() {
      this.user = null;
    },
  },
});
