import { createStore } from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import * as Cookies from 'js-cookie';

const store = createStore({
  state: {
    user: null,
  },
  getters: {
    getUser(state) {
      return state.user;
    },
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
    },
  },
  actions: {
    setUser({ commit }, user) {
      commit('setUser', user);
    },
  },
  plugins: [
    createPersistedState({
      key: 'portal',
      storage: {
        getItem: (key) => Cookies.get(key),
        setItem: (key, value) => Cookies.set(key, value, { expires: 1/6, secure: false }),
        removeItem: (key) => Cookies.remove(key),
      },
    }),
  ],
});

export default store;