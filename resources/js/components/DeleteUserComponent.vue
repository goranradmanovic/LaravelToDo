<template>
    <div class="container">
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
                <button type="button" class="btn btn-danger" @click.prevent="deleteSingleUserInformation(userId), closeModal()">Delete</button>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
  import { EventBus } from '../bus/events.js';
  import { mapActions } from 'vuex';

  export default {
    name: 'DeleteUserComponent',
    data() {
      return {
        userId: null
      }
    },

    methods: {
      ...mapActions([
        'deleteSingleUserInformation',
      ]),

      listenDeleteEvent() {
        EventBus.$on('deleteUser', payload => {
          this.userId = payload;
        });
      },

      closeModal() {
        $('#deleteModal').modal('hide');
      }
    },

    mounted() {
      this.listenDeleteEvent();
    }
  }
</script>
