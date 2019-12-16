<template>
    <div class="container">
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
              <button type="button" class="btn btn-success" @click.prevent="setUserDataObject(), editSingleUserInformation(user), closeModal()">Edit</button>
            </div>
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
    name: 'EditUserComponent',
    data() {
      return {
        userId: null, //User Id
        form: {
          name: '' //User name
        },
        user: {
          id: null,
          name: null
        }
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
      ...mapActions([
        'editSingleUserInformation',
      ]),

      listenEditEvent() {
        EventBus.$on('edit', payload => {
          this.userId = payload.id;
          this.form.name = payload.name;
        });
      },

      //Format data for sending
      setUserDataObject() {
        this.user.id = this.userId;
        this.user.name = this.form.name;
      },

      closeModal() {
        $('#editModal').modal('hide');
      }
    },

    mounted() {
      this.listenEditEvent();
    }
  }
</script>
