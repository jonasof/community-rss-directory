import { mount } from '@vue/test-utils'
import Form from 'components/Feeds/Form'
import { defer, assign } from 'lodash'

import i18n from 'setup/i18n'

let wrapper = null
let mountOptions = null

beforeEach(() => {
  mountOptions = {
    stubs: {
      TagsInput: true
    },
    i18n,
    propsData: {
      form: {
        id: 0,
        title: "",
        url: "",
        homepage: "",
        description: "",
        tags: "",
        type: "",
        icon_url: ""
      }
    },
    sync: false
  }

  wrapper = mount(Form, mountOptions);
})

afterEach(() => {
  wrapper.destroy();
  window.mockedAxios.reset();
});

describe('Form component', () => {
  test('show page title', async () => {
    expect(wrapper.text()).toMatch(/New Feed/)
  })

  describe('url', () => {
    test('after type invalid url show erros', async () => {
      window.mockedAxios.onGet().reply(422);

      wrapper.vm.form.url = "http://google.com"
      wrapper.vm.url_changed = true // @TODO fix not triggered automatically,

      await wrapper.vm.fetchFeedInformation()

      expect(wrapper.text()).toMatch(/Invalid Source/)
      expect(wrapper.vm.errors.has('url')).toBeTruthy()
    })

    test('after type valid url show no errors', async () => {
      window.mockedAxios.onGet().reply(200, {});

      wrapper.vm.form.url = "http://google.com"
      wrapper.vm.url_changed = true // @TODO fix not triggered automatically,

      await wrapper.vm.fetchFeedInformation()

      expect(wrapper.vm.errors.has('url')).toBeFalsy()
      expect(wrapper.text()).not.toMatch(/Invalid Source/)
    })
  })

  describe('fetchFeedInformation', () => {
    test('fills the instance form data', async () => {
      const data =  {
        "title":"Xadrez Verbal",
        "description":"Pol\u00edtica, Hist\u00f3ria, atualidades e um pouco de autoterapia",
        "url":"https:\/\/feeds.feedburner.com\/XadrezVerbal",
        "homepage":"https:\/\/xadrezverbal.com",
        "type":"podcast"
      }

      window.mockedAxios.onGet().reply(200, data);

      wrapper.vm.form.url = "https://feeds.feedburner.com/XadrezVerbal"
      wrapper.vm.url_changed = true // @TODO fix not triggered automatically,

      await wrapper.vm.fetchFeedInformation()

      expect(wrapper.vm.form.title).toEqual(data.title)
      expect(wrapper.vm.form.description).toEqual(data.description)
      expect(wrapper.vm.form.url).toEqual(data.url)
      expect(wrapper.vm.form.homepage).toEqual(data.homepage)
      expect(wrapper.vm.form.type).toEqual(data.type)
    })
  })

  describe('submit', () => {
    test('if success emit event', async() => {
      window.mockedAxios.onPost().reply(200);

      wrapper.setProps({form: {
        "title":"Xadrez Verbal",
        "description":"Pol\u00edtica, Hist\u00f3ria, atualidades e um pouco de autoterapia",
        "icon_url":null,
        "url":"https:\/\/feeds.feedburner.com\/XadrezVerbal",
        "homepage":"https:\/\/xadrezverbal.com",
        "type":"podcast"
      }});
      const result = await wrapper.vm.submit()

      expect(result).toBeTruthy()
      expect(wrapper.emitted().saved.length).toBe(1)
    })

    test('if any errors occurs show input alerts', async() => {
      window.mockedAxios.onPost().reply(400, {
        "message":"The given data was invalid.",
        "errors":{
          "title": ["The title cannot be empty."]
        }
      });

      wrapper.setProps({form: {
        "title":"",
        "description":"Pol\u00edtica, Hist\u00f3ria, atualidades e um pouco de autoterapia",
        "icon_url":null,
        "url":"https:\/\/feeds.feedburner.com\/XadrezVerbal",
        "homepage":"https:\/\/xadrezverbal.com",
        "type":"podcast"
      }});
      const result = await wrapper.vm.submit()

      expect(result).toBeFalsy()
      expect(wrapper.text()).toMatch(/The title cannot be empty/)
    })

    test('if has id use put instead of post', async() => {
      window.mockedAxios.onPut().reply(200);

      wrapper.setProps({form: {
        "id": 1,
        "title":"Xadrez Verbal",
        "description":"Pol\u00edtica, Hist\u00f3ria, atualidades e um pouco de autoterapia",
        "icon_url":null,
        "url":"https:\/\/feeds.feedburner.com\/XadrezVerbal",
        "homepage":"https:\/\/xadrezverbal.com",
        "type":"podcast"
      }});
      const result = await wrapper.vm.submit()

      expect(result).toBeTruthy()
      expect(wrapper.emitted().saved.length).toBe(1)
    })
  })
})
