import Vue from 'vue';
import Vuex from 'vuex';

//Partials files
import actions from './actions.js';
import getters from './getters.js';
import mutations from './mutations.js';

Vue.use(Vuex);


export const store = new Vuex.Store({

  state: {
    users: null, //All users data
    taskUsername: null,
    done: '<p class="font-weight-bold font-italic text-success mb-0">Done</p>',
    todo: '<p class="font-weight-bold font-italic text-warning mb-0">To Do</p>',
    infoMessage: null, //Info notification message
    loader: null, //Table data loader
    //Create form data
    form: {
      user_id: null,
      description: '',
      status: null
    },
    tasks: null,
  },

  actions,
  getters,
  mutations
});
