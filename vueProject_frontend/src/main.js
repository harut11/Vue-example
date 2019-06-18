// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import axios from 'axios'
import bootstrap from 'bootstrap-vue'
import store from '@/store'
import "@/scss/main.scss"
import VeeValidate from 'vee-validate'

axios.defaults.baseURL = process.env.API_URL;


Vue.use(bootstrap);
Vue.use(VeeValidate, {
  classes: true,
  classNames: {
    valid: 'is-valid',
    invalid: 'is-invalid'
  }
});

Vue.config.productionTip = false;

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
});