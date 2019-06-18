<template>
    <div>
        <h1>{{ pageName }}</h1>
        <button @click="homeRoute()">posts</button>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                pageName: 'asdasd'
            }
        },
        methods: {
            homeRoute(){
                this.$router.push({name:'Home'})
            }
        }
    }
</script>