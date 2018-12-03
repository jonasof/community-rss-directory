export default {
  getDefaultLocale () {
    return 'en';
  },
  getCurrentLocale () {
    return localStorage.getItem('language') || navigator.language || this.getDefaultLocale();
  }
}