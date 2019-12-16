<template>
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
            <button type="button" class="btn btn-success" @click="setTaskDataObject(), editSingleTaskInformation(task), closeModal()">Edit</button>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
  import { EventBus } from '../bus/events.js';
  import { mapActions } from 'vuex';
  import { required, minLength } from 'vuelidate/lib/validators';

  export default {
    name: 'EditTaskComponent',
    data() {
      return {
        taskId: null, //User Id
        form: {
          description: '', //Task description
          status: null  	//Task status
        },
        task: {
          id: null,
          description: null,
          status: null
        }
      }
    },

    //Task validation
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
      ...mapActions([
        'editSingleTaskInformation',
      ]),

      //Old data for populatin modal edit form
      listenEditTaskEvent() {
        EventBus.$on('editTask', payload => {
          this.taskId = payload.id;
          this.form.description = payload.description;
          this.form.status = payload.status;
        });
      },

      //Format data for sending
      setTaskDataObject() {
        this.task.id = this.taskId;
        this.task.description = this.form.description;
        this.task.status = this.form.status == 'true' ? true : false;
      },

      closeModal() {
        $('#editModal').modal('hide');
      }
    },

    mounted() {
      this.listenEditTaskEvent();
    }
  }
</script>
