<template>
    <div class="container">
        <div class="box-content">
            <div v-if="message" class="alert alert-success" role="alert">
                {{message}}
            </div>
            <form class="w-50 m-auto" @submit.prevent="reset" method="post">
                <div class="form-group">
                    <label for="forgotEmail1">Email address</label>
                    <input type="email" class="form-control" id="forgotEmail1" data-vv-name="email"
                           placeholder="Enter email" v-model="email" v-validate="'required|email'">
                    <span class="error-div">{{ errors.first('email') }}</span>
                </div>
                <button type="submit" class="btn btn-success">Reset</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                email: '',
                message: ''
            }
        },
        methods: {
            reset() {
                this.$store.dispatch('reset', this.email).then(res => {
                    this.message = this.$store.getters['getForgotMessage'];
                })
            }
        }
    }
</script>

<style scoped>

</style>