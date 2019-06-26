import Vue from 'vue'
import axios from 'axios'
import Vuex from 'vuex'
Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        myTestData: null,
        userDetails: null,
        forgotMessage: ''
    },
    actions: {
        getTestDataFromAPI(context, url){
            return new Promise((resolve, reject) => {
                axios.get(url).then((res)=> {
                    context.commit('setTestData', res.data.posts.data);
                    resolve()
                }).catch((err)=> {
                    console.log(err.response);
                    reject()
                })
            })
        },
        logout(context){
            return new Promise((resolve, reject) => {
                this.userDetails = null;
                localStorage.removeItem('access_token');
                localStorage.removeItem('user');
                resolve()
            })

        },
        reset(context, email){
            return new Promise((resolve, reject) => {
                axios.get('reset', {
                    params: {
                        email: email
                    }
                }).then(res => {
                    context.commit('setForgotMessage', res.data.message);
                    resolve();
                })
            });
        }
    },
    mutations: {
        setTestData(state, data){
            state.myTestData = data;
        },
        setUserData(state, data) {
            state.userDetails = data;
            localStorage.setItem('user', JSON.stringify(data))
        },
        setForgotMessage(state, data) {
            state.forgotMessage = data;
        }
    },
    getters: {
        getTestData(state){
            return state.myTestData;
        },
        getUserData(state) {
            if(!state.userDetails) {
                state.userDetails = JSON.parse(localStorage.getItem('user'))
            }
            return state.userDetails;
        },
        getForgotMessage(state) {
            return state.forgotMessage;
        }
    }
})