<template>
    <div class="container">
        <div class="box-content">
            <form class="w-50 m-auto" @submit.prevent="updatePost()">
                <div class="form-group">
                    <label for="post-title">Title</label>
                    <input type="text" v-model="title" data-vv-name="title" class="form-control" id="post-title"
                           placeholder="Enter title"  v-validate="'required|min:3|max:30'">
                    <span class="error-div">{{ errors.first('title') }}</span>
                </div>
                <div class="form-group">
                    <label for="post-description">Description</label>
                    <textarea class="form-control" id="post-description" data-vv-name="description"
                              placeholder="Enter description" v-validate="'required|min:5|max:100'" v-model="description"></textarea>
                    <span class="error-div">{{ errors.first('description') }}</span>
                </div>
                <small class="form-text text-danger mt-3">{{errorText}}</small>
                <button type="submit" class="btn btn-outline-dark mt-2">Update</button>
            </form>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import { TokenService } from "../store/service";

    export default {
        data() {
            return {
                title: '',
                description: '',
                errorText: ''
            }
        },
        mounted() {
            let id = +(this.$route.params.id),
                posts = this.$store.getters['getTestData'];
            if (posts) {
                posts.forEach((item)=> {
                    if (item.id === id) {
                        this.title = item.title;
                        this.description = item.description;
                    }
                });
            } else {
                this.$store.dispatch('getTestDataFromAPI', 'posts').then(()=> {
                    this.posts = this.$store.getters['getTestData'];
                    this.posts.forEach((item)=> {
                        if (item.id === id) {
                            this.title = item.title;
                            this.description = item.description;
                        }
                    })
                });
            }
        },
        methods: {
            updatePost() {
                this.$validator.validate().then(valid => {
                    if (!valid) {
                        return false;
                    } else {
                        axios.defaults.headers.common["Authorization"] = `Bearer ${TokenService.getToken()}`;
                        var id = this.$route.params.id;
                        axios.put('posts/' + id, {
                            title: this.title,
                            description: this.description
                        }).catch((err) => {
                            console.log(err);
                        }).then((res) => {
                            let error = res.data.message;

                            if (error) {
                                this.errorText = error;
                            } else {
                                this.$router.push({name:'Posts'});
                            }
                        });
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>