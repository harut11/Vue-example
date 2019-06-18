import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import Dashboard from '@/components/Dashboard'
import Posts from '@/components/Posts'
import  CreatePost from '@/components/CreatePost'
import EditPost from '@/components/EditPost'
import Login from '@/components/auth/Login'
import Register from '@/components/auth/Register'
import Verify from '@/components/auth/Verify'
import { TokenService } from "../store/service";

Vue.use(Router);

const router =  new Router({
  mode: 'history',
  saveScrollPosition: true,
  routes: [
    {path: '/', name: 'Home', component: Home, meta: {public: true, onlyWhenLoggedOut: false}},
    {path: '/dashboard', name: 'Dashboard', component: Dashboard},
    {path: '/posts', name: 'Posts', component: Posts, meta: {public: false, onlyWhenLoggedOut: false}},
    {path: '/create-post', name: 'CreatePost', component: CreatePost},
    {path: '/posts', name: 'StorePost', meta: {public: false, onlyWhenLoggedOut: false}},
    {path: '/posts/:id/edit',name: 'EditPost',component: EditPost, meta: {public: false, onlyWhenLoggedOut: false}},
    {path: '/user-login', name: 'Login',component: Login, meta: {public: true, onlyWhenLoggedOut: true}},
    {path: '/user-register', name: 'Register', component: Register, meta: {public: true, onlyWhenLoggedOut: true}},
    {path: '/verify', name: 'Verify', component: Verify, meta: {public: true, onlyWhenLoggedOut: true}},
    {path: '/logout', name: 'Logout', meta: {public: false, onlyWhenLoggedOut: false},},
  ]
});

router.beforeEach((to, from, next) => {
  const isPublic = to.matched.some(record => record.meta.public);
  const onlyWhenLoggedOut = to.matched.some(record => record.meta.onlyWhenLoggedOut);
  const loggedIn = TokenService.getToken();

  if (!isPublic && !loggedIn) {
    return router.push({name: 'Login'});
  }

  if (loggedIn && onlyWhenLoggedOut) {
    return next('/');
  }

  next();
});

export default router