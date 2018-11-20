<template lang="pug">
  div
    .text-center
      font-awesome-icon(icon="spinner" pulse size="4x" v-if='loading')
    preview(:feed="feed" v-if='!loading')
</template>

<script>
  import Preview from './Preview'
  import Parser from 'rss-parser'

  export default {
    props: ['url'],
    components: {
      Preview
    },
    data () {
      return {
        feed: {},
        loading: true
      };
    },
    mounted () {
      this.parser = new Parser();
      this.downloadFeed();
    },
    methods: {
      async downloadFeed () {
        this.feed = {};
        this.loading = true;

        try {
          let result = await axios.get(this.url);
          this.feed = await this.parser.parseString(result.data);
        } catch (e) {
        }

        this.loading = false;
      }
    },
    watch: {
      url () {
        this.downloadFeed();
      }
    }
  }
</script>