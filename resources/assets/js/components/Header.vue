<template>
  <nav class="navbar navbar-dark na vbar-expand-lg" style="background-color: rgb(50, 52, 54)">
    <div class="container">
        <a class="navbar-brand" href="#/">Community RSS Directory</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="#/">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#/new">New</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/api/feeds/export" download>Export</a>
            </li>
          </ul>
        </div>
    </div>
  </nav>
</template>

<script>
  import $ from 'jquery'

  export default {
    mounted () {
      let el = $(this.$el)

      el.find('.navbar-nav > li > a').on('click', () => {
        el.find('.navbar-collapse').collapse('hide');
      });
    }
  }
</script>