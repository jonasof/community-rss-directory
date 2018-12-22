import { mount } from '@vue/test-utils'
import HeaderTest from 'components/Header'

import i18n from 'setup/i18n'

test('should mount without crashing', () => {
  const wrapper = mount(HeaderTest, {
    i18n
  })
})