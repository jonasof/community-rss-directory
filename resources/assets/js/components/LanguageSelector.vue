<template>
  <div class="uls-trigger">
    {{ languageName }}
  </div>
</template>

<script>
  import 'jquery.uls/src/jquery.uls.data.js'
  import 'jquery.uls/src/jquery.uls.data.utils.js'
  import 'jquery.uls/src/jquery.uls.lcd.js'
  import 'jquery.uls/src/jquery.uls.languagefilter.js'
  import 'jquery.uls/src/jquery.uls.core.js'

  export default {
    data () {
      return {
        currentLanguage: this.setupCurrentLanguage()
      }
    },
    mounted () {
      window.$( '.uls-trigger' ).uls({
        languages: {
            en: 'English',
            'pt-br': 'Português (Brasil)'
        },
        onSelect: (language) => {
          this.setLanguage(language)
        },
      });
    },
    methods: {
      setupCurrentLanguage () {
        const storedLanguage = localStorage.getItem('language')

        console.log(storedLanguage)

        if (storedLanguage) {
          return storedLanguage;
        }

        localStorage.setItem('language', navigator.language || 'en');

        return navigator.language
      },
      setLanguage (language) {
        language = this.toLocale(language);

        this.currentLanguage = language;
        localStorage.setItem('language', language);
        this.$i18n.locale = language;
      },
      toLocale (ulsLanguage) {
        let language = ulsLanguage.split('-');
        if (language.length == 2) {
          language[1] = language[1].toUpperCase();
        }
        return language.join('-');
      },
      toUls (localeLanguage) {
        let language = localeLanguage.split('-');
        if (language.length == 2) {
          language[1] = language[1].toLowerCase();
        }
        return language.join('-');
      }
    },
    computed: {
      languageName () {
         return $.uls.data.getAutonym(this.toUls(this.currentLanguage));
      }
    }
  }
</script>

<style lang="scss" scoped>
  .uls-trigger {
    cursor: pointer;
  }
</style>

<style lang="scss">
  .uls-search {
    display: none;
  }

  .uls-lcd {
    height: 8em;
  }
</style>