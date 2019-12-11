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

      <div class="card">
          <div class="card-header">Create Task</div>

          <div class="card-body">
            <form @submit="onSubmit($event)">
              <div class="form-group row">
                <label for="exampleFormControlTextarea1">Task description</label>
                <div class="col-sm-10">
                  <textarea class="form-control" v-model="form.description" id="exampleFormControlTextarea1" rows="5"></textarea>

                  <div v-if="!$v.form.description.required" class="text-danger">
                    <p>Field is required</p>
                  </div>

                  <div v-if="!$v.form.description.minLength" class="text-danger">
                    <p>Name must have at least {{$v.form.description.$params.minLength.min}} letters.</p>
                  </div>
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
              <div class="form-group row">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary" :disabled="!$v.form.description.minLength || !$v.form.description.required || !$v.form.status.required">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
    </div>
</template>

<script>

  import { required, minLength } from 'vuelidate/lib/validators';

  export default {
    name: 'CreateTaskComponent',
    props: ['userid'],
    data() {
      return {
        form: {
          description: '',
          status: null
        },
        show: true,
        infoMessage: ''
      }
    },

    validations: {
      form: {
        description: {
          required,
          minLength: minLength(3)
        },
        status: {
          required
        }
      }
    },

    methods: {
      onSubmit(evt) {
        evt.preventDefault()

        this.form.user_id = this.userid; //Add user id to the form data

        //Send call to create task API
        axios.post('/api/tasks', this.form).then(function (response) {
          this.infoMessage = response.data;
          this.onReset(evt);
        }.bind(this))
        .catch(function (error) {
          console.log(error);
        });
      },

      //Reset the form
      onReset(evt) {
        evt.preventDefault()
        // Reset our form values
        this.form.description = '';
        this.form.status = '';
        this.form.user_id = '';

        // Trick to reset/clear native browser form validation state
        this.show = false
        this.$nextTick(() => {
          this.show = true
        })
      }
    }
  }
</script>
