<template>
  <div class="container">
    <div class="box-content">
      <h1>{{ pageName }}</h1>
      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's
        standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make
        a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
        remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing
        Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions
        of Lorem Ipsum.</p>
    </div>
  </div>
</template>

<script>
  import axios from 'axios'
export default {
  name: 'Home',
  data () {
    return {
      msg: 'Welcome to Home page',
      pageName: 'Home',
      posts: []
    }
  },
  methods: {
    getPosts(){
      this.$store.dispatch('getTestDataFromAPI', 'posts').then(()=> {
        this.posts = this.$store.getters['getTestData'];
      })
    },
    clearPosts(){
      this.$store.commit('setTestData', null);
      this.posts = this.$store.getters['getTestData'];
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
