<template lang="pug">
  div
    h1 {{ feed.title }}
    p {{ feed.description }}

    hr

    ul.list-unstyled
      li(v-for='article in feed.items')
        article-item(:article="article")
</template>

<script>
  import ArticleItem from "./Article"

  export default {
    components: { ArticleItem },
    props: ['feed'],
    filters: {
      localeDateTime (value) {
        return (new Date(value)).toLocaleString()
      }
    }
  }
</script>

<style lang="scss" scoped>
  h1 {
    font-size: 30px;
    font-weight: bold;
  }

  li {
    margin: 30px 0;
  }
</style>