let isDev = false,
    allowOrigin = isDev ? 'http://localhost:8000' : 'http://aqueous-ravine-65951.herokuapp.com/';

//Get function for collecting data
let get = (url) => {
  return axios.get(url, {
    crossDomain: true,
    headers: {
      'Access-Control-Allow-Origin':  '*',
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'signature': 'asd',
      'Access-Control-Allow-Headers': 'X-Requested-With',
      'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE',
      data:{}
    }
  });
};

//Post function for sending data
let post = (url, data) => {
  return axios.post(url, data, {
    crossDomain: true,
    headers: {
      'Access-Control-Allow-Origin': allowOrigin,
      'Content-Type': 'application/json',
      data:{}
    }
  });
};

//patch for updating the data
let patch = (url, data) => {
  return axios.patch(url, data, {
    crossDomain: true,
    headers: {
      'Access-Control-Allow-Origin': allowOrigin,
      'Content-Type': 'application/json',
      data:{}
    }
  })
};

//deleting for updating the data
let deleting = (url, data) => {
  return axios.delete(url, data, {
    crossDomain: true,
    headers: {
      'Access-Control-Allow-Origin': allowOrigin,
      'Content-Type': 'application/json',
      data:{}
    }
  })
};

export default {

  /*** User section ***/
  /*Get all users information*/
  getUsersInformations() {
    return get('api/users');
  },

  editUserInformations(data) {
    return patch(`api/users/${data.id}`, {name: data.name});
  },

  deleteUserInformations(id) {
    return deleting(`api/users/${id}`);
  },
  /*** End of users section ***/

  /*** Tasks section ***/

  //Get all tasks from user
  getUserTasks(id) {
    return get(`api/users/${id}`);
  },

  //Create task
  postCreateTask(data) {
    return post('api/tasks', data);
  },

  //Edit task
  editTaskInformations(data) {
    return patch(`api/tasks/${data.id}`, data);
  },

  //Delete task
  deleteTaskInformations(id) {
    return deleting(`api/tasks/${id}`);
  }
}
