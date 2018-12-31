<template>
  <nav class="navbar navbar-dark na vbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#/">Community RSS Directory</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link homepage" href="#/">{{ $t('feeds.actions.homepage') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link new" href="#/new">{{ $t('feeds.actions.new') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link export" href="/api/feeds/export" download>{{ $t('feeds.actions.export') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link">
                <LanguageSelector></languageselector>
              </a>
            </li>
          </ul>
        </div>
    </div>
  </nav>
</template>

<script>
  import $ from 'jquery'
  import LanguageSelector from './LanguageSelector'

  export default {
    mounted () {
      let el = $(this.$el)

      el.find('.navbar-nav > li > a').on('click', () => {
        el.find('.navbar-collapse').collapse('hide');
      });
    },
    components: {
      LanguageSelector
    }
  }
</script>

<style lang="scss" scoped>
  .navbar-dark {
    background-color: rgb(50, 52, 54)
  }
</style>