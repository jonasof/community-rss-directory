import VueI18n from 'vue-i18n'
import messages from '../Messages'

import locale from '../locale'

export default new VueI18n({
  messages,
  locale: locale.getCurrentLocale(),
  fallbackLocale: 'en'
})
