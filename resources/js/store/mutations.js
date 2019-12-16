export default {
  /*** Users ***/
  //All user data
  setUsersInformations(state, data) {
    state.users = data;
  },

  //Edited user data
  setEditedUserInformations(state, data) {
    state.users = state.users.filter(item => {
      //If item if from users is equal to passed data id
      if (item.id == data.id) {
        item.name = data.name; //Then set users item name to edited data name (from edit user form)
      }

      return this; //current data
    });
  },

  //Deleted user
  setDeletedUserInformations(state, data) {
    state.users = state.users.filter(item => {
      return item.id != data;
    });
  },

  /*** Assets ***/
  //Info notification message
  setResponseInfoMessage(state, data) {
    state.infoMessage = data;
  },

  //Table data loader
  setLoader(state, data) {
    state.loader = data;
  },

  /*** Tasks ***/
  //Clear tasks create form after submitting new task
  setDefaultFormData(state) {
    state.form = {
      user_id: null,
      description: '',
      status: null
    }
  },

  //Set all tasks
  setTasksInformations(state, data) {
    state.tasks = data[0].tasks;
    state.taskUsername = data[0].name;
  },

  //Set new data for UI
  setEditedTaskInformations(state, data) {

    state.tasks = state.tasks.filter(item => {
      //If item if from tasks is equal to passed data id
      if (item.id == data.id) {
        //Then set tasks item fields to edited data fields (from edit task form)
        item.description = data.description;
        item.status = data.status;
      }

      return this; //current data
    });
  },

  //Set new data for IU
  setDeletedTaskInformations(state, data) {
    state.tasks = state.tasks.filter(item => {
      return item.id != data;
    });
  }
}
