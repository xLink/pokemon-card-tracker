import { getField, updateField } from 'vuex-map-fields';
import Vue from 'vue';

const state = {
  profile: {}
};

const getters = {
  getField,
  getProfile: (state) => state.profile,
  isProfileLoaded: (state) => !!Object.keys(state.profile).length,
};

const actions = {

};

const mutations = {
  updateField,
  UPDATE_PROFILE: (state, payload) => {
    Vue.set(state, 'profile', payload);
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
