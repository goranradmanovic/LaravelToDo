<template>
    <div class="container">

       <infomessage-component v-if="infoMessage" :message="infoMessage" :alert-type="'alert-primary'"></infomessage-component>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Task List from <span class="lead">{{ taskUsername }}</span></div>

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
                          <tr v-for="(item, index) in tasks" :key="index">
                            <td>{{ index + 1 }}</td>
                            <td>
                              {{ item.description }} <br>
                              <small class="text-secondary">{{ item.created_at }}</small>
                            </td>
                            <td v-html="item.status ? done : todo"></td>
                            <td><button type="button" class="btn btn-primary" :data-id="item.id" :data-desc="item.description" :data-radiobtn="item.status" data-toggle="modal" data-target="#editModal" @click="setTaskData($event), emmitEditTaskEvent()">Edit</button></td>
                            <td><button type="button" class="btn btn-danger" :data-id="item.id" :data-desc="true" :data-radiobtn="true" data-toggle="modal" data-target="#deleteModal" @click="setTaskData($event), emmitDeleteTaskEvent()">Delete</button></td>
                          </tr>
                          <tr v-if="tasks != null && tasks.length == 0">
                            <td colspan="5"><strong>No tasks</strong></td>
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

        <!-- Edit modal -->
        <edittask-component></edittask-component>

        <!-- Delete modal -->
        <deletetask-component></deletetask-component>
    </div>
</template>

<script>
  import { EventBus } from '../bus/events.js';
  import { mapActions, mapGetters } from 'vuex';

  export default {
    name: 'UserListComponent',
    data() {
      return {
        userId: null, //User ID
        //Task object for sending
        task: {
          id: null,
          description: null,
          status: null
        }
      }
    },

    computed: {
      ...mapGetters([
        'loader',
        'infoMessage',
        'tasks',
        'taskUsername',
        'todo',
        'done'
      ])
    },

    methods: {
      //Get and set user ID from URL
      setUserId() {
        let urlPathname = window.location.pathname.split('/');

        this.userId = urlPathname[urlPathname.length - 1];
      },

      //Emit event for editing task and pass task data
      emmitEditTaskEvent() {
        EventBus.$emit('editTask', this.task);
      },

      //Emit event for editing task and pass task id
      emmitDeleteTaskEvent() {
        EventBus.$emit('deleteTask', this.task.id);
      },

      //Set task old data
      setTaskData(event) {
        this.task.id = event.target.dataset.id;
        this.task.description = event.target.dataset.desc;
        this.task.status = (event.target.dataset.radiobtn == '1' || event.target.dataset.radiobtn == 'true') ? true : false;
      },

      ...mapActions([
        'tasksInformations',
        'editSingleUserInformation'
      ]),
    },

    mounted() {
      this.setUserId();
      this.tasksInformations(this.userId);
    }
  }
</script>
