<template lang="pug">
  feeds-form(v-model="form", @saved="redirectSuccess()")

</template>

<script>
  import TagsInput from '@voerro/vue-tagsinput';
  import VeeValidate from 'vee-validate';
  import { forOwn } from 'lodash'
  import FeedsForm from "../../components/Feeds/Form"

  export default {
    components: {
      TagsInput,
      feedsForm: FeedsForm
    },
    props: ['id'],
    data () {
      return {
        form: {
          id: 0,
          title: "",
          url: "",
          homepage: "",
          description: "",
          tags: "",
          type: "",
          icon_url: ""
        }
      };
    },
    async mounted () {
      if (this.id) {
        let response = await this.$axios.get(`/api/feeds/${this.id}`, this.form);
        this.form = response.data;
      }
    },
    methods: {
      redirectSuccess() {
        this.$router.push('/');
      }
    }
  }
</script>