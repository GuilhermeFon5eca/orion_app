/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import './bootstrap';


import { createApp } from 'vue';
import { i18nVue } from 'laravel-vue-i18n'

/* Import vuex */
import { createStore } from 'vuex';
const store = createStore({
    state () {
      return {
        count: 0,
        item: {},
        transaction: {
          status: '',
          message: '',
          errors: '',
        }
      }
    },
    // mutations: {
    //   increment (state) {
    //     state.count++
    //   }
    // }
  })


/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

import Login from './components/Login.vue';
app.component('login-component', Login);

import Home from './components/Home.vue';
app.component('home-component', Home);

import Brands from './components/Brands.vue';
app.component('brands-component', Brands);

import inputContainer from './components/inputContainer.vue';
app.component('input-container-component', inputContainer);

import Table from './components/Table.vue';
app.component('table-component', Table);

import Card from './components/Card.vue';
app.component('card-component', Card);

import Modal from './components/Modal.vue';
app.component('modal-component', Modal);

import Alert from './components/Alert.vue';
app.component('alert-component', Alert);

import Paginate from './components/Paginate.vue';
app.component('paginate-component', Paginate);

import Dashboard from './views/main/Dashboard.vue';
app.component('dashboard-component', Dashboard);

import ChatsComponent from './components/ChatsComponent.vue';
app.component('chats', ChatsComponent);

import Crud from './views/crud/Crud.vue';
app.component('crud-component', Crud);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
app.use(store);
//Use i18 vue localization
app.use(i18nVue, {
  resolve: async lang => {
      const langs = import.meta.glob('../../lang/*.json');
      return await langs[`../../lang/${lang}.json`]();
  }
})

app.config.globalProperties.$filters = {
  formatDateTime(d) {
    if(!d) return ''
      d = d.split('T')
      let data = d[0]
      let tempo = d[1]
      //formatando a data
      data = data.split('-')
      data = data[2]+'/'+data[1]+'/'+data[0]

      // formatando o tempo
      tempo = tempo.split('.')
      tempo = tempo[0]
      
      return data +' '+tempo
  }
}

app.config.globalProperties.$globalData ={
  baseUrl: import.meta.env.VITE_APP_URL ?? 'no_url',
};


app.mount('#app');