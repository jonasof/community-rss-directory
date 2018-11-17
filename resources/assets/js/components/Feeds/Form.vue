<template lang="pug">
  div
    h2
      | New Feed Source
    p.alert.alert-warning
      | Warning: your IP address is stored when adding or editing (like wikipedia).
      | The data are used to identify vandalism.
    .form-group
      label(for="url") Url:
      input.form-control(
        id="url"
        name="url"
        v-validate="'required|url'"
        v-model="form.url"
        @blur='fetchFeedInformation()'
        v-bind:class="{ 'is-invalid': errors.has('url') }"
      )
      .invalid-feedback {{ errors.first('url') }}

    .form-group
      label(for="url") Type:
      select.form-control(
        id="type"
        name="type"
        v-validate="'required'"
        v-model="form.type"
        @blur='fetchFeedInformation()'
        v-bind:class="{ 'is-invalid': errors.has('type') }"
      )
        option(value="rss") Text RSS
        option(value="podcast") Podcast
      .invalid-feedback {{ errors.first('type') }}

    .form-group
      label(for="homepage") Homepage:
      input.form-control(
        id="homepage"
        name="homepage"
        v-model="form.homepage"
        v-validate="'url'"
        v-bind:class="{ 'is-invalid': errors.has('homepage') }"
      )
      .invalid-feedback {{ errors.first('homepage') }}

    .form-group
      label(for="title") Title:
      input.form-control(
        id="title"
        name="title"
        v-model="form.title"
        v-validate="'required'"
        v-bind:class="{ 'is-invalid': errors.has('title') }"
      )
      .invalid-feedback {{ errors.first('title') }}

    .form-group
      label(for="description") Description:
      input.form-control(
        id="description"
        name="description"
        v-model="form.description"
        v-bind:class="{ 'is-invalid': errors.has('description') }"
      )
      .invalid-feedback {{ errors.first('description') }}

    .form-group
      label(for="tags") Tags
      tags-input(
        element-id="tags"
        v-model="form.tags"
        :typeahead="false"
      )

    button.btn.btn-primary(href='', @click.prevent="submit", :disabled="errors.any()")
      | Save
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
          type: ""
        },
        valid_url: false
      }
    },
    async mounted () {
      if (this.id) {
        let response = await axios.get(`/api/feeds/${this.id}`, this.form);
        this.form = response.data;
      }
    },
    methods: {
      async submit() {
        try {
          await axios({
            method: this.id ? 'put' : 'post',
            url: this.id ? `/api/feeds/${this.id}` : '/api/feeds',
            data: this.form
          });
          this.$router.push('/');
        } catch (e) {
          if (!e.response.data.errors) return

          for (let [key, value] of Object.entries(e.response.data.errors)) {
            this.$validator.errors.add(key, value.join(', '));
          }
        }
      },
      async fetchFeedInformation () {
        if (!(await this.$validator.validate('url'))) {
          return
        }

        try {
          const result = await axios.get('/api/feeds/parse', {
            params: {
              url: this.form.url
            }
          });

          forOwn(result.data, (value, key) => {
            this.form[key] = value
          })

          this.errors.remove('url');
        } catch (e) {
          this.errors.add('url', 'Fonte Inválida');
        }
      }
    }
  }
</script>

<style scoped lang="sass">
    @import '~@voerro/vue-tagsinput/dist/style.css';
</style>