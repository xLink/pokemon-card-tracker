import { getField, updateField } from 'vuex-map-fields';

const state = {
  loading: false,
  loadingCount: 0,
  debug: {
    ajax: true,
    store: !true,
    mutations: !true,
  },
};

const getters = {
  getField,

  debug: (state) => state.debug,
};

const actions = {
  clearLoading: ({commit}) => {
    commit('CLEAR_LOADING');
  },
  setLoading: ({state, commit}, payload) => {
    if (payload === true) {
      commit('INC_LOADING');
    } else {
      commit('DEC_LOADING');
    }

    commit('SET_LOADING', state.loadingCount > 0);
  }
};

const mutations = {
  updateField,
  SET_LOADING: (state, payload) => {
    state.loading = payload;
  },
  INC_LOADING: (state) => {
    state.loadingCount += 1;
  },
  DEC_LOADING: (state) => {
    state.loadingCount -= 1;
  },
  CLEAR_LOADING: (state) => {
    state.loadingCount = 0;
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
