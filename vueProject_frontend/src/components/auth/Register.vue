<template>
    <div class="container">
        <div class="box-content">
            <form class="w-50 m-auto" @submit.prevent="register()">
                <div class="form-group">
                    <label for="exampleInputName">First name</label>
                    <input type="text" class="form-control" id="exampleInputName" data-vv-name="name"
                           placeholder="Enter First name" v-model="name" v-validate="'required|min:2|max:100'">
                    <span class="error-div">{{ errors.first('name') }}</span>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" data-vv-name="email"
                           aria-describedby="emailHelp" placeholder="Enter email" v-validate="'required|email'" v-model="email">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    <span class="error-div">{{ errors.first('email') }}</span>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" v-model="password" data-vv-name="password" ref="password"
                           id="exampleInputPassword1" placeholder="Password" v-validate="'required|min:6|max:35'">
                    <span class="error-div">{{ errors.first('password') }}</span>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword2">Confirm password</label>
                    <input type="password" class="form-control" data-vv-name="confirm_password" id="exampleInputPassword2"
                           placeholder="Confirm password" v-validate="'required|confirmed:password'" data-vv-as="password">
                    <span>{{ errors.first('confirm_password') }}</span>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        data() {
            return {
                name: '',
                email: '',
                password: ''
            }
        },
        methods: {
            register() {
                axios.post('/auth/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password
                }).catch(error => {
                    console.log(error);
                    if (error.response) {
                        console.log(error.response.data);
                        console.log(error.response.status);
                        console.log(error.response.headers);
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log('Error', error.message);
                    }
                    console.log(error.config);
                }).then(res => {
                    this.$router.push({name:'Login'});
                });
            }
        }
    }
</script>

<style scoped>

</style>