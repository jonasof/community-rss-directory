<template lang="pug">
  div
    h2 {{ $t('feeds.new') }}
    p.alert.alert-warning {{ $t('ip_registered') }}
    .form-group
      label(for="url") {{ $t('feeds.fields.url') }}:
      input.form-control(
        id="url"
        name="url"
        v-validate="'required|url'"
        v-model="form.url"
        @blur='fetchFeedInformation()'
        v-bind:class="{ 'is-invalid': errors.has('url') }"
      )
      .invalid-feedback {{ errors.first('url') }}

    marquee(v-if='url_is_loading')
      | {{ $t('loading') }}...

    .form-group
      label(for="url") {{ $t('feeds.fields.type') }}:
      select.form-control(
        id="type"
        name="type"
        v-validate="'required'"
        v-model="form.type"
        v-bind:class="{ 'is-invalid': errors.has('type') }"
        :readonly='url_is_loading'
      )
        option(value="rss") Text RSS
        option(value="podcast") Podcast
      .invalid-feedback {{ errors.first('type') }}

    .form-group
      label(for="homepage") {{ $t('feeds.fields.homepage') }}:
      input.form-control(
        id="homepage"
        name="homepage"
        v-model="form.homepage"
        v-validate="'url'"
        v-bind:class="{ 'is-invalid': errors.has('homepage') }"
        :readonly='url_is_loading'
      )
      .invalid-feedback {{ errors.first('homepage') }}

    .form-group
      label(for="title") {{ $t('feeds.fields.title') }}:
      input.form-control(
        id="title"
        name="title"
        v-model="form.title"
        v-validate="'required'"
        v-bind:class="{ 'is-invalid': errors.has('title') }"
        :readonly='url_is_loading'
      )
      .invalid-feedback {{ errors.first('title') }}

    .form-group
      label(for="description") {{ $t('feeds.fields.description') }}:
      input.form-control(
        id="description"
        name="description"
        v-model="form.description"
        v-bind:class="{ 'is-invalid': errors.has('description') }"
        :readonly='url_is_loading'
      )
      .invalid-feedback {{ errors.first('description') }}

    .form-group
      label(for="icon_url") {{ $t('feeds.fields.icon_url') }}:
      input.form-control(
        id="icon_url"
        name="icon_url"
        v-model="form.icon_url"
        v-validate="'url'"
        v-bind:class="{ 'is-invalid': errors.has('icon_url') }"
        :readonly='url_is_loading'
      )
      .invalid-feedback {{ errors.first('icon_url') }}

    .form-group
      label(for="tags") {{ $t('feeds.fields.tags') }}:
      tags-input(
        element-id="tags"
        v-model="form.tags"
        :typeahead="false"
        placeholder=""
        :readonly='url_is_loading'
      )

    button.btn.btn-primary(href='', @click.prevent="submit", :readonly="errors.any()") {{ $t('feeds.actions.save') }}
</template>

<script>
  import TagsInput from '@voerro/vue-tagsinput';
  import VeeValidate from 'vee-validate';
  import { forOwn } from 'lodash'

  export default {
    components: { TagsInput },
    props: ['id'],
    data () {
      return {
        form: {
          title: "",
          url: "",
          homepage: "",
          description: "",
          tags: "",
          type: "",
          icon_url: ""
        },
        valid_url: false,
        url_is_loading: false,
        url_changed: false
      }
    },
    async mounted () {
      if (this.id) {
        let response = await this.$axios.get(`/api/feeds/${this.id}`, this.form);
        this.form = response.data;
      }
    },
    methods: {
      async submit() {
        try {
          await this.$axios({
            method: this.id ? 'put' : 'post',
            url: this.id ? `/api/feeds/${this.id}` : '/api/feeds',
            data: this.form
          });
        } catch (e) {
          if (!e.response.data.errors) return false;

          for (let [key, value] of Object.entries(e.response.data.errors)) {
            this.$validator.errors.add(key, value.join(', '));
          }

          return false;
        }
        this.$router.push('/');

        return true;
      },
      async fetchFeedInformation () {
        if (!(await this.$validator.validate('url'))) {
          return
        }

        if (!this.url_changed) {
          return;
        }

        this.url_is_loading = true;

        try {
          const result = await this.$axios.get('/api/feeds/parse', {
            params: {
              url: this.form.url
            }
          });

          forOwn(result.data, (value, key) => {
            this.form[key] = value
          })

          this.errors.remove('url');
        } catch (e) {
          this.errors.add('url', this.$t('feeds.errors.invalid_source'));
        }

        this.url_is_loading = false;
        this.url_changed = false;
      }
    },
    watch: {
      'form.url' (url) {
        this.url_changed = true
      }
    }
  }
</script>

<style scoped lang="sass">
    @import '~@voerro/vue-tagsinput/dist/style.css'

    marquee
      width: 200px
</style>