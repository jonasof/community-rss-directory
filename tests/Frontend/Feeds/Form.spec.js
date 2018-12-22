import { mount } from '@vue/test-utils'
import Form from 'components/Feeds/Form'
import { defer } from 'lodash'

import i18n from 'setup/i18n'

let wrapper = null
let $router = null
let mountOptions = null

beforeEach(() => {
  $router = {
    push: jest.fn(() => {})
  }

  mountOptions = {
    stubs: {
      TagsInput: true
    },
    i18n,
    mocks: {
      $router
    }
  }

  wrapper = mount(Form, mountOptions)
});

afterEach(() => {
  window.mockedAxios.reset();
})

test('show page title', () => {
  expect(wrapper.text()).toMatch(/New Feed/)
})

describe('url', () => {
  test('after type invalid url show erros', async () => {
    window.mockedAxios.onGet().reply(422);

    wrapper.vm.form.url = 'http://google.com'
    await wrapper.vm.fetchFeedInformation()

    expect(wrapper.vm.errors.has('url')).toBeTruthy()
    expect(wrapper.text()).toMatch(/Invalid Source/)
  })

  test('after type valid url show no errors', async () => {
    window.mockedAxios.onGet().reply(200, {});

    wrapper.vm.form.url = 'http://google.com'
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

    window.mockedAxios.onGet().reply(200,data);

    wrapper.vm.form.url = 'https:\/\/feeds.feedburner.com\/XadrezVerbal'
    await wrapper.vm.fetchFeedInformation()

    expect(wrapper.vm.form.title).toEqual(data.title)
    expect(wrapper.vm.form.description).toEqual(data.description)
    expect(wrapper.vm.form.url).toEqual(data.url)
    expect(wrapper.vm.form.homepage).toEqual(data.homepage)
    expect(wrapper.vm.form.type).toEqual(data.type)
  })
})

describe('submit', () => {
  test('if success redirect to home', async() => {
    window.mockedAxios.onPost().reply(200);

    wrapper.vm.form = {
      "title":"Xadrez Verbal",
      "description":"Pol\u00edtica, Hist\u00f3ria, atualidades e um pouco de autoterapia",
      "icon_url":null,
      "url":"https:\/\/feeds.feedburner.com\/XadrezVerbal",
      "homepage":"https:\/\/xadrezverbal.com",
      "type":"podcast"
    }
    const result = await wrapper.vm.submit()

    expect(result).toBeTruthy()
    expect($router.push).toBeCalledWith('/')
  })

  test('if any errors occurs show input alerts', async() => {
    window.mockedAxios.onPost().reply(400, {
      "message":"The given data was invalid.",
      "errors":{
        "title": ["The title cannot be empty."]
      }
    });

    wrapper.vm.form = {
      "title":"",
      "description":"Pol\u00edtica, Hist\u00f3ria, atualidades e um pouco de autoterapia",
      "icon_url":null,
      "url":"https:\/\/feeds.feedburner.com\/XadrezVerbal",
      "homepage":"https:\/\/xadrezverbal.com",
      "type":"podcast"
    }
    const result = await wrapper.vm.submit()

    expect(result).toBeFalsy()
    expect(wrapper.text()).toMatch(/The title cannot be empty/)
  })
})

describe('mounted', () => {
  test('if id is set calls to fetch feed information', async() => {
    window.mockedAxios.onGet().reply(200, {
      title: 'editing feed'
    });

    mountOptions.propsData = {
      id: 1
    }

    wrapper = mount(Form, mountOptions)
    await window.defer()

    expect(wrapper.vm.form.title).toEqual('editing feed')
  })
})