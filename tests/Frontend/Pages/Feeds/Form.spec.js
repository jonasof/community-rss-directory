import { mount } from '@vue/test-utils'
import FormComponent from 'components/Feeds/Form'
import Form from 'pages/Feeds/Form'
import { defer, assign } from 'lodash'

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
    },
    sync: false
  }

  wrapper = mount(Form, mountOptions);
})

afterEach(() => {
  wrapper.destroy();
  window.mockedAxios.reset();
});

describe('Feed Form Page component', () => {
  test('show page title', async () => {
    expect(wrapper.text()).toMatch(/New Feed/)
  })
})

describe('mounted', () => {
  test('if id is set calls to fetch feed information', async() => {
    window.mockedAxios.onGet().reply(200, {
      title: 'editing feed'
    });

    mountOptions.propsData = {id: 1};

    wrapper.destroy();
    wrapper = mount(Form, mountOptions); /** @TODO Refactor, each test should do the main task */
    await window.defer()

    expect(wrapper.vm.form.title).toEqual('editing feed')
  })
})

test('if component emit success redirect page', async() => {
  window.mockedAxios.onPost().reply(200, {
    title: 'editing feed'
  });

  wrapper.find(FormComponent).vm.$emit("saved");

  expect($router.push.mock.calls.length).toEqual(1);
})