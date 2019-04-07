<template lang="pug">
  div
    h2 {{ $t('feeds.import_opml') }}
    p.alert.alert-warning {{ $t('ip_registered') }}

    div(v-if="feeds.length === 0")
      .form-group
        label(for="file") {{ $t('feeds.fields.file') }}:
        input.form-control-file(
          id="file"
          name="file"
          type="file"
          ref="file"
          v-bind:class="{ 'is-invalid': errors.has('file') }"
          @change="handleFileUpload()"
        )
        .invalid-feedback {{ errors.first('file') }}
      button.btn.btn-primary(href='', @click.prevent="submit", :readonly="errors.any()") {{ $t('feeds.actions.continue') }}
    div(v-else)
      .card.mb-3(v-for="(feed, index) in feeds" v-if="!feed.id")
        .card-body
          feed-form(v-model="feeds[index]", @saved="removeSaved(index)")
            template(v-slot:ip-track-alert)
              div
</template>

<script>
  import FeedForm from './Form'
  import VeeValidate from 'vee-validate'
  import { forOwn } from 'lodash'

  export default {
    components: {
      feedForm: FeedForm
    },
    props: ['id'],
    data () {
      return {
        feeds: [],
        form: {
          file: ""
        }
      };
    },
    methods: {
      handleFileUpload(){
        this.file = this.$refs.file.files[0];
      },
      async submit() {
        const formData = new FormData();
        formData.append('feeds', this.file);

        try {
          const result = await this.$axios({
            method: 'post',
            url: '/api/feeds/import/parse-file',
            data: formData,
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          });

          this.feeds = result.data;
        } catch (e) {
          alert("Cannot parse file!");
          if (!e.response.data.errors) return false;

          for (let [key, value] of Object.entries(e.response.data.errors)) {
            this.$validator.errors.add({
              field: key,
              msg: value.join(', ')
            });
          }
        }
      },
      removeSaved (index) {
        this.$delete(this.feeds, index)
      }
    }
  }
</script>

<style scoped lang="sass">
  @import '~@voerro/vue-tagsinput/dist/style.css'

  marquee
    width: 200px
</style>