<template lang="pug">
  div
    h2 {{ $t('feeds.list') }}
    p(v-if='tag')
      | Tag: {{ tag }}
      a.btn.btn-danger.btn-sm(href="#/")
        | X
    vdtnet-table(
      :key='tableKey'
      ref='table'
      :fields="datatables.fields",
      :opts="datatables.options"
      class-name="table table-striped table-bordered w-100"
      @preview="preview"
      @openFeed="openFeed"
    )
    previewModal(ref='preview')

</template>

<script>
  import ListColumns from "./ListColumns"
  import VdtnetTable from 'vue-datatables-net'
  import PreviewModal from './PreviewModal'

  export default {
    props: ['tag'],
    components: { VdtnetTable, PreviewModal },
    data () {
      return {
        datatables: this.getDatatableOptions(),
        tableKey: 'table'
      }
    },
    methods: {
      getDatatableOptions () {
        return {
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
                  request.tag = this.tag;
                }
              }
            },
            initComplete: () => {
              $(this.$refs.table.$el).on('change', ".column_search", (options) => {
                this.$refs.table.dataTable
                  .column( $(options.target).parent().index() )
                  .search( options.target.value )
                  .draw();
              });
            },
            language: {
              paginate: {
                previous: this.$t('datatables.previous'),
                next: this.$t('datatables.next')
              }
            }
          },
          fields: this.getColumns()
        };
      },
      getColumns() {
        return ListColumns(this.$i18n);
      },
      preview (data) {
        this.$refs.preview.show(`/api/feeds/${data.id}/download`);
      },
      openFeed (data) {
        if (navigator.share) {
          navigator.share({
            title: data.title,
            text: data.description,
            url: data.url
          }).catch(() => window.open(data.url,'_blank'));
        } else {
          window.open(data.url,'_blank');
        }
      }
    },
    watch: {
      tag () {
        this.$refs.table.dataTable.ajax.reload();
      },
      '$i18n.locale' () {
        this.datatables = this.getDatatableOptions();

        this.tableKey = 'loading';
        this.$nextTick(() => {
          this.tableKey = 'table';
        })
      }
    }
  }
</script>

<style lang="scss" scoped>
  .vdtnet-container {
    width: 100% !important;
  }

  .vdtnet-container /deep/ .action {
    white-space: nowrap;
    letter-spacing: 18px;

    a {
      font-size: 18px;
    }
  }

  .vdtnet-container /deep/ .online {
    color: green;
  }

  .vdtnet-container /deep/ .offline {
    color: red;
  }
</style>