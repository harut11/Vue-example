<template>
    <div class="container">
        <div class="box-content">
            <form class="w-50 m-auto" @submit.prevent="setPassword">
                <div class="form-group">
                    <label for="resetPassword">Password</label>
                    <input type="password" class="form-control" v-model="password" data-vv-name="password" ref="password"
                           id="resetPassword" placeholder="Password" v-validate="'required|min:6|max:35'">
                    <span class="error-div">{{ errors.first('password') }}</span>
                </div>
                <div class="form-group">
                    <label for="resetConfirmPassword">Confirm password</label>
                    <input type="password" class="form-control" data-vv-name="confirm_password" id="resetConfirmPassword"
                           placeholder="Confirm password" v-validate="'required|confirmed:password'" data-vv-as="password">
                    <span>{{ errors.first('confirm_password') }}</span>
                </div>
                <div v-if="tokenError" class="alert alert-danger" role="alert">
                    {{tokenError}}
                </div>
                <button type="submit" class="btn btn-primary">Reset password</button>
            </form>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        data() {
            return {
                password: '',
                message: '',
                tokenError: ''
            }
        },
        methods: {
            setPassword() {
                return new Promise((resolve, reject) => {
                    axios.get('/setPassword', {
                        params: {
                            token: this.$route.query.token,
                            password: this.password
                        }
                    }).catch(err => {
                        if (err.response.data.errors.token) {
                            this.tokenError = err.response.data.errors.token[0];
                        }
                        reject();
                    }).then(res => {
                        if (res) {
                            this.message = res.data.message;
                            this.$router.push({name: 'Login'});
                            resolve();
                        }
                    })
                })
            }
        }
    }
</script>

<style scoped>

</style>