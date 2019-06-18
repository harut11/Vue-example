<template>
  <div>
    <Header></Header>
    <router-view/>
    <Footer></Footer>
  </div>
</template>

<script>
  import Header from './components/templates/Header'
  import Footer from './components/templates/Footer'
  import axios from 'axios'

  export default {
    components : {Header, Footer},
    name: 'App',
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
    }
}
</script>

<style>
</style>
