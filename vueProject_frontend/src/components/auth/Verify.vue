<template>
    <div class="container">
        <div class="box-content">
            {{showMessage}}
            <h1 v-if="message">{{ message }}</h1>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        data() {
            return {
                message: ''
            }
        },
        computed: {
            showMessage: function() {
                axios.get('auth/verify?token=' + this.$route.query.token).catch(err => {
                    console.log(err);
                }).then(res => {
                    this.message = res.data.message;
                })
            }
        }
    }
</script>

<style scoped>

</style>