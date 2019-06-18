<template>
  <div>
    <vue-topprogress ref="topProgress"></vue-topprogress>
    <Header></Header>
    <router-view/>
    <Footer></Footer>
  </div>
</template>

<script>
  import Header from './components/templates/Header'
  import Footer from './components/templates/Footer'
  import axios from 'axios'
  import Vue from 'vue'
  import { vueTopprogress } from 'vue-top-progress'

  Vue.use(vueTopprogress);

  export default {
    components : {Header, Footer, vueTopprogress},
    created: function () {
      axios.interceptors.response.use(undefined, function (err) {
        return new Promise(function (resolve, reject) {
          if (err.status === 401 && err.config && !err.config.__isRetryRequest) {
            this.$store.dispatch('logout');
            resolve();
          } else {
            throw err;
          }
        })
      });
    },
    mounted() {
      this.$refs.topProgress.start();

      // Use setTimeout for demo
      setTimeout(() => {
        this.$refs.topProgress.done();
      }, 2000)
    }
}
</script>

<style>
</style>
