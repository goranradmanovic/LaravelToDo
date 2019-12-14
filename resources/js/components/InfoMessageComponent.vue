<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div :class="[alertType, 'alert alert-dismissible fade show']" role="alert">
        <strong ref="alert-content">{{ message }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'InfoMessageComponent',
    props: ['message', 'alertType'], //alert-type
    data() {
      return {

      }
    },

    methods: {

    },

    mounted() {

    }
  }
</script>
