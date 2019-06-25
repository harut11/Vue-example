<template>
    <div class="container">
        <div class="box-content">
            <form class="w-50 m-auto" @submit.prevent="login()">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" data-vv-name="email"
                           aria-describedby="emailHelp" placeholder="Enter email" v-model="email" v-validate="'required|email'">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    <span class="error-div">{{ errors.first('title') }}</span>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" data-vv-name="password" id="exampleInputPassword1"
                           placeholder="Password" v-model="password" v-validate="'required|min:6|max:35'">
                    <span class="error-div">{{ errors.first('title') }}</span>
                </div>
                <a href="" @click.prevent="goForgot">Forgot password</a>
                <small class="form-text text-danger mt-3">{{errorText}}</small>
                <button type="submit" class="btn btn-primary mt-2">Login</button>
            </form>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import { TokenService } from "../../store/service";

    export  default {
        data() {
            return {
                email: '',
                password: '',
                errorText: ''
            }
        },
        methods: {
            login() {
                return new Promise((resolve, reject) => {
                    axios.post('auth/login', {
                        email: this.email,
                        password: this.password
                    }).then(res => {
                        if (res.data.access_token) {
                            TokenService.setToken(res.data.access_token);
                            axios.defaults.headers.common["Authorization"] = `Bearer ${TokenService.getToken()}`;
                            this.$store.commit('setUserData', res.data.user);
                            this.$root.$emit('login')
                        }
                        this.$router.push('/');
                        resolve();
                    }).catch(err => {
                        this.errorText = err.response.data.message;
                        reject();
                    });
                });
            }
        }
    }
</script>

<style scoped>

</style>