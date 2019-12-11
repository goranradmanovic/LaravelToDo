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
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">User List</div>

                    <div class="card-body">
                      <!-- User table -->
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(item, index) in items" :key="index">
                            <th scope="row">{{ index + 1 }}</th>
                            <td><a :href="'/user-tasks?id=' + item.id">{{ item.name }}</a></td>
                            <td><button type="button" class="btn btn-primary" :data-id="item.id" :data-name="item.name" data-toggle="modal" data-target="#editModal" @click="setUserId($event), setUserName($event)">Edit</button></td>
                            <td><button type="button" class="btn btn-danger" :data-id="item.id" data-toggle="modal" data-target="#deleteModal" @click="setUserId($event)">Delete</button></td>
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
                <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Do you really want to delete the user?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" @click="deleteUser()">Delete</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Do you really want to edit the user?</p>
                <form>
                  <div class="form-group">
                    <label for="exampleFormControlInput1">User Name</label>
                    <input type="text" v-model="form.name" class="form-control" required id="exampleFormControlInput1" placeholder="John Doe">

                    <div v-if="!$v.form.name.required" class="text-danger">
                      <p>Field is required</p>
                    </div>

                    <div v-if="!$v.form.name.minLength" class="text-danger">
                      <p>Name must have at least {{$v.form.name.$params.minLength.min}} letters.</p>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" @click="editUser($event)">Edit</button>
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
    props: [
      'users'
    ],
    data() {
      return {
        items: [], //Arra of all users
        userId: null, //User ID
        form: {
          name: '' //User name
        },
        infoMessage: ''
      }
    },

    //User name validation
    validations: {
      form: {
        name: {
          required,
          minLength: minLength(3)
        },
      }
    },

    methods: {
      //Gett all users from API
      getUsers() {
          this.items = this.users;
      },

      //Set User ID
      setUserId(event) {
        this.userId = event.target.dataset.id;
      },

      //Set User name
      setUserName(event) {
        this.form.name = event.target.dataset.name;
      },

      //Delete User from DB
      deleteUser() {
        //Check if user ID is set
        if (this.userId) {
          axios.delete(`api/users/${this.userId}`).then(function(response) {
            // handle success

            this.infoMessage = response.data;

            //Update user UI list
            this.items = this.items.filter(item => {
              return item.id != this.userId;
            });

            this.userId = null; //Set user ID to null

            $('#deleteModal').modal('hide');

          }.bind(this))
          .catch(error => {
            // handle error
            console.log(error);
          });
        }
      },

      //Edit current user
      editUser(event) {
        event.preventDefault(); //Prevent default form behaivor

        //Check if user ID is set
        if (this.userId) {
          axios.patch(`api/users/${this.userId}`, {name: this.form.name}).then(function(response) {
            // handle success

            this.infoMessage = response.data;

            //Update user UI list
            this.items = this.items.filter(item => {
              if (item.id == this.userId) {
                item.name = this.form.name;
              }

              return this.items;
            });

            this.userId = null; //Set user ID to null
            this.form.name = ''; //Set user name to empty string
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
      this.getUsers(); //Get list of all user when component is mounted
    },
  }
</script>
