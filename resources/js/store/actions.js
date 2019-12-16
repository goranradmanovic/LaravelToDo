import apiService from '../services/apiServices.js';

export default {

  /**** User section ****/
  //All users data
  usersInformations({commit}) {

    commit('setLoader', true);

    apiService.getUsersInformations().then(response => {
      //console.log('dataUsersInformations', response);
      commit('setUsersInformations', response.data);
      commit('setLoader', false);
    }).catch(error => {
      console.log('Error ',  error);
    });
  },

  //Edit user data
  editSingleUserInformation({commit}, data) {
    apiService.editUserInformations(data).then(response => {
      commit('setResponseInfoMessage', response.data);
      commit('setEditedUserInformations', data);
    }).catch(error => {
      console.log('Error ', error);
    });
  },

  //Delete current user
  deleteSingleUserInformation({commit}, id) {
    apiService.deleteUserInformations(id).then(response => {
      commit('setResponseInfoMessage', response.data); //Set info notification message
      commit('setDeletedUserInformations', id); //Set delete user
    }).catch(error => {
      console.log('Error ',  error);
    });
  },
  /**** End of user section ****/

  /**** Task section ****/
  //Get all users tasks
  tasksInformations({commit}, id) {
    commit('setLoader', true);

    apiService.getUserTasks(id).then(response => {
      commit('setTasksInformations', response.data);
      commit('setLoader', false);
    }).catch(error => {
      console.log('Error ', error);
    })
  },

  //Create nse user task
  createUserTask({commit}, data) {
    apiService.postCreateTask(data).then(response => {
      commit('setResponseInfoMessage', response.data);
      commit('setDefaultFormData');
    }).catch(error => {
      console.log('Error ', error);
    });
  },

  //Edit user data
  editSingleTaskInformation({commit}, data) {
    apiService.editTaskInformations(data).then(response => {
      commit('setResponseInfoMessage', response.data);
      commit('setEditedTaskInformations', data);
    }).catch(error => {
      console.log('Error ', error);
    });
  },

  //Delete current task
  deleteSingleTaskInformation({commit}, id) {
    apiService.deleteTaskInformations(id).then(response => {
      commit('setResponseInfoMessage', response.data); //Set info notification message
      commit('setDeletedTaskInformations', id); //Set delete user
    }).catch(error => {
      console.log('Error ',  error);
    });
  },

  /**** End of task section ****/
}
