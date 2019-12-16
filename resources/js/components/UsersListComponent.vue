<template>
    <div class="container">
       <!-- Info notification message -->
       <infomessage-component v-if="infoMessage" :message="infoMessage" :alert-type="'alert-primary'"></infomessage-component>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Users List</div>

                    <div class="card-body">
                      <!-- User table -->
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(item, index) in users" :key="index">
                            <th scope="row">{{ index + 1 }}</th>
                            <td><a :href="`/users/${item.id}`">{{ item.name }}</a></td>
                            <td>{{ item.email }}</td>
                            <td><button type="button" class="btn btn-primary" :data-id="item.id" :data-name="item.name" data-toggle="modal" data-target="#editModal" @click="setUserData($event), emmitEditEvent()">Edit</button></td>
                            <td><button type="button" class="btn btn-danger" :data-id="item.id" :data-name="item.name" data-toggle="modal" data-target="#deleteModal" @click="setUserData($event), emmitDeleteUserEvent()">Delete</button></td>
                          </tr>

                          <tr v-if="users != null && users.length == 0">
                            <td colspan="5"><strong>No users</strong></td>
                          </tr>

                          <tr v-if="loader">
                            <td colspan="5" class="text-center">
                              <div class="spinner-border text-info"></div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit user modal -->
       <edituser-component></edituser-component>
       <!-- Delete user modal -->
       <deleteuser-component></deleteuser-component>
    </div>
</template>

<script>
  import { EventBus } from '../bus/events.js';
  import { mapActions, mapGetters } from 'vuex';

  export default {
    name: 'UserListComponent',
    data() {
      return {
        //User object for formating data
        user: {
          id: null,
          name: null
        }
      }
    },

    computed: {
      ...mapGetters([
        'users',
        'infoMessage',
        'loader',
      ])
    },

    methods: {

      //Set User data
      setUserData(event) {
        this.user.id = event.target.dataset.id;
        this.user.name = event.target.dataset.name;
      },

      //Emit event for editing user and pass user name
      emmitEditEvent() {
        EventBus.$emit('edit', this.user);
      },

      //Emit event for editing user and pass user name
      emmitDeleteUserEvent() {
        EventBus.$emit('deleteUser', this.user.id);
      },

      ...mapActions([
        'usersInformations',
        'deleteSingleUserInformation',

      ])
    },

    mounted() {
      //Get all users from API
      this.usersInformations();
    },
  }
</script>
