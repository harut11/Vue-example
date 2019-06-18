<template>
  <div class="container">
    <div class="box-content">
      <h1>{{ pageName }}</h1>
      <button @click="getPosts()">Button</button>
      <div v-if="posts">
        <div v-for="post in posts">
          <div>{{ post.title }}</div>
          <div>{{ post.description }}</div>
        </div>
      </div>
      <button @click="clearPosts()">Clear</button>
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
