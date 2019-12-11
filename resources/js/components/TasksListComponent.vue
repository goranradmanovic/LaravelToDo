<template>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="alert alert-primary alert-dismissible fade show" role="alert" v-if="infoMessage">
            <strong ref="alert-content">{{ infoMessage }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
      </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Task List from {{ username }}</div>

                    <div class="card-body">
                      <!-- User table -->
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Description</th>
                            <th scope="col">Status</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(item, index) in items" :key="index">
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.description }}</td>
                            <td v-html="item.status ? done : todo"></td>
                            <td><button type="button" class="btn btn-primary" :data-id="item.id" :data-desc="item.description" :data-radiobtn="item.status" data-toggle="modal" data-target="#editModal" @click="setTaskId($event), setTaskOldData($event)">Edit</button></td>
                            <td><button type="button" class="btn btn-danger" :data-id="item.id" data-toggle="modal" data-target="#deleteModal" @click="setTaskId($event)">Delete</button></td>
                          </tr>
                          <tr v-if="items.length == 0">
                            <td colspan="5"><strong>No tasks</strong></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Do you really want to delete the task?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" @click="deleteTask()">Delete</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Do you really want to edit the task?</p>
                <form>
                  <div class="form-group">
                    <label for="exampleFormControlInput1">Task Description</label>
                    <textarea v-model="form.description" class="form-control" required id="exampleFormControlInput1" placeholder="John Doe" rows="5"></textarea>

                    <div v-if="!$v.form.description.required" class="text-danger">
                      <p>Field is required</p>
                    </div>

                    <div v-if="!$v.form.description.minLength" class="text-danger">
                      <p>Name must have at least {{$v.form.description.$params.minLength.min}} letters.</p>
                    </div>
                  </div>

                  <fieldset class="form-group">
                    <div class="row">
                      <legend class="col-form-label col-sm-2 pt-0">Status</legend>
                      <div class="col-sm-10">
                        <div class="form-check">
                          <input class="form-check-input" v-model="form.status" type="radio" name="gridRadios" id="gridRadios1" value="true" required>
                          <label class="form-check-label" for="gridRadios1">Done</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" v-model="form.status" type="radio" name="gridRadios" id="gridRadios2" value="false" required>
                          <label class="form-check-label" for="gridRadios2">ToDo</label>
                        </div>

                        <div v-if="!$v.form.status.required" class="text-danger">
                          <p>Field is required</p>
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" @click="editTask($event)">Edit</button>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
  import { required, minLength } from 'vuelidate/lib/validators';

  export default {
    name: 'UserListComponent',
    props: ['tasks', 'username'],
    data() {
      return {
        items: [], //Arra of all users
        taskId: null, //User ID
        form: {
          description: '', //Task description
          status: null
        },
        infoMessage: '',
        done: '<p class="font-weight-bold font-italic text-success">Done</p>',
        todo: '<p class="font-weight-bold font-italic text-warning">To Do</p>'
      }
    },

    //User name validation
    validations: {
      form: {
        description: {
          required,
          minLength: minLength(3)
        },
        status: {
          required
        },
      }
    },

    methods: {
      //Gett all users from API
      getTasks() {
          this.items = this.tasks;
      },

      //Set User ID
      setTaskId(event) {
        this.taskId = event.target.dataset.id;
      },

      //Set User name
      setTaskOldData(event) {
        this.form.description = event.target.dataset.desc;
        this.form.status = event.target.dataset.radiobtn == '1' ? true : false;
      },

      //Delete User from DB
      deleteTask() {
        //Check if user ID is set
        if (this.taskId) {
          axios.delete(`api/tasks/${this.taskId}`).then(function(response) {
            // handle success

            this.infoMessage = response.data;

            //Update user UI list
            this.items = this.items.filter(item => {
              return item.id != this.taskId;
            });

            this.taskId = null; //Set task ID to null

            $('#deleteModal').modal('hide');

          }.bind(this))
          .catch(error => {
            // handle error
            console.log(error);
          });
        }
      },

      //Edit current user
      editTask(event) {
        event.preventDefault(); //Prevent default form behaivor

        //Check if task ID is set
        if (this.taskId) {
          axios.patch(`api/tasks/${this.taskId}`, this.form).then(function(response) {
            // handle success

            this.infoMessage = response.data;

            //Update task UI list
            this.items = this.items.filter(item => {
              if (item.id == this.taskId) {
                item.description = this.form.description;
                item.status = this.form.status == 'true' ? true : false;
              }

              return this.items;
            });

            this.taskId = null; //Set task ID to null
            this.form.description = ''; //Set task desc. to empty string
            $('#editModal').modal('hide');

          }.bind(this))
          .catch(error => {
            // handle error
            console.log(error);
          });
        }
      }
    },

    mounted() {
      this.getTasks(); //Get list of all user when component is mounted
    },
  }
</script>
