// store/index.js

import { createStore } from 'vuex';

export default createStore({
  state: {
    isAuthenticated: localStorage.getItem('token') ? true : false,
    token: localStorage.getItem('token'),
    todos: Array
  },
  mutations: {
    setAuthenticated(state, isAuthenticated) {
      state.isAuthenticated = isAuthenticated;
    },
    setToken(state, token) {
      state.token = token;
    }
  }
});