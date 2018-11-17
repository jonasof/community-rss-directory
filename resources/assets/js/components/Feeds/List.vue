<template lang="pug">
  div
    h2 Feed List
    p(v-if='tag')
      | Tag: {{ tag }}
      a.btn.btn-danger.btn-sm(href="#/")
        | X
    vdtnet-table(
      ref='table'
      :fields="datatables.fields",
      :opts="datatables.options"
      class-name="table table-striped table-bordered w-100"
    )

</template>

<script>
  import ListColumns from "./ListColumns"
  import VdtnetTable from 'vue-datatables-net'

  export default {
    props: ['tag'],
    components: { VdtnetTable: VdtnetTable },
    data () {
      return {
        datatables: {
          options: {
            pageLength: 50,
            lengthMenu: [ 10, 25, 50, 100 ],
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
              url: '/api/feeds',
              data: (request) => {
                if (this.tag) {
                  request.tag = this.tag
                }
              }
            }
          },
          fields: ListColumns
        }
      }
    },
    mounted () {
      $(this.$refs.table.$el).on('change', ".column_search", (options) => {
        this.$refs.table.dataTable
          .column( $(options.target).parent().index() )
          .search( options.target.value )
          .draw();
      });
    },
    watch: {
      tag () {
        this.$refs.table.dataTable.ajax.reload()
      }
    }
  }
</script>

<style lang="scss" scoped>
  table {
    width: 100% !important;
  }
</style>
