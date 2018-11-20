<template lang="pug">
  article
    header
      h3.title {{ article.title }}
      time.pubdate 🕑 {{ article.pubDate | localeDateTime }}
    .content(v-html="article.content")
    enclosure(:enclosure="article.enclosure", v-if='article.enclosure')
    a(:href='article.link').readmore Read More
</template>

<script>
  import Enclosure from "./Enclosure"

  export default {
    components: { Enclosure },
    props: ['article'],
    filters: {
      localeDateTime (value) {
        return (new Date(value)).toLocaleString()
      }
    }
  }
</script>


<style lang="scss" scoped>
  h3 {
    font-size: 20px;
  }

  /deep/ img {
    max-width: 100%;
  }
</style>