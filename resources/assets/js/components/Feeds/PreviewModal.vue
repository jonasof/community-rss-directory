<template>
  <div ref='modal' class="modal fade" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Feed Preview</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <previewer :url='url' v-if='url' />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Previewer from '../Preview/Previewer'

  export default {
    components: { Previewer },
    data () {
      return {
        url: ''
      }
    },
    methods: {
      show (url) {
        this.url = url
        $(this.$refs.modal).modal('show');
      }
    }
  }
</script>