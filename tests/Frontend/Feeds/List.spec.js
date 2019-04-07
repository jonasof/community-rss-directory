import { mount } from '@vue/test-utils'
import ListComponent from 'components/Feeds/List'

import i18n from 'setup/i18n'

let wrapper = null
beforeEach(() => {
  wrapper = mount(ListComponent, {
    i18n,
    sync: false
  })
});

afterEach(() => {
  wrapper.destroy();
  window.mockedAxios.reset();
});

test('should build url for export', () => {
  const searchUrl = wrapper.vm.getExportTableUrl();

  expect(searchUrl).toMatch(/\/api\/feeds\/export\?/)
  expect(searchUrl).toMatch(/columns/)
  expect(searchUrl).toMatch(/search/)
})