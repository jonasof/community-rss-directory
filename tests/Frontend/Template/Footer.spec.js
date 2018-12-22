import { mount } from '@vue/test-utils'
import FooterTest from 'components/Footer'

import i18n from 'setup/i18n'

test('should mount without crashing', () => {
  const wrapper = mount(FooterTest, {
    i18n
  })
})