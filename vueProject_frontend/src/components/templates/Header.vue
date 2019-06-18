<template>
   <header>
       <div class="container h-100">
           <div class="d-flex justify-content-between align-items-center h-100">
               {{show}}
               <div id="app-logo">
                   <a @click="goHome()">{{ appName }}</a>
               </div>
               <nav>
                   <ul class="row" v-if="!auth">
                       <li class="mr-2" >
                           <a @click="goLogin()">login</a>
                       </li>
                       <li>
                           <a @click="goRegister()">Register</a>
                       </li>
                   </ul>
                   <div v-else>
                       <dropdown>
                           <template slot="btn">{{userName.name}}</template>
                           <template slot="body">
                               <ul class="user-dropdown">
                                   <li class="mr-2">
                                       <a @click="goPosts()">Posts</a>
                                   </li>
                                   <li>
                                       <a @click.prevent="logout()">Log out</a>
                                   </li>
                               </ul>
                           </template>
                       </dropdown>
                   </div>
               </nav>
           </div>
       </div>
   </header>
</template>

<script>
    import Dropdown from 'bp-vuejs-dropdown';
    import axios from 'axios';
    import { TokenService } from "../../store/service";

    export default {
        data() {
            return {
                appName: 'Vue Test',
                auth: false,
                userName: null
            }
        },
        components: {Dropdown},
        mounted () {
            this.$root.$on('login', () => {
                this.checkOut();
            });
            this.checkOut();
        },
        computed: {
            show: function () {
                this.userName = this.$store.getters['getUserData'];
            }
        },
        methods: {
            checkOut(){
                this.auth = (localStorage.getItem('access_token') !== null)
            },
            goPosts() {
               this.$router.push({name:'Posts'});
            },
            goHome() {
                this.$router.push({name:'Home'});
            },
            goLogin() {
                this.$router.push({name:'Login'});
            },
            goRegister() {
                this.$router.push({name:'Register'});
            },
            logout() {
                axios.defaults.headers.common["Authorization"] = `Bearer ${TokenService.getToken()}`;
                axios.post('auth/logout').catch(err => {
                    console.log(err);
                });
                if(this.auth){
                    this.$store.dispatch('logout').then((res) => {
                        this.$router.push({name: 'Login'});
                        this.$root.$emit('login');
                    });
                }
            }
        }
    }
</script>

<style scoped>
    .user-dropdown li a {
        color: #000;
    }
</style>