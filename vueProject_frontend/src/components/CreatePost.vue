<template>
    <div class="container">
        <div class="box-content">
            <form class="w-50 m-auto" @submit.prevent="storePost()">
                <div class="form-group">
                    <label for="post-title">Title</label>
                    <input type="text" v-model="title" data-vv-name="title" class="form-control" id="post-title"
                           placeholder="Enter title" v-validate="'required|min:3|max:30'">
                    <span class="error-div">{{ errors.first('title') }}</span>
                </div>
                <div class="form-group">
                    <label for="post-description">Description</label>
                    <textarea class="form-control" id="post-description" v-model="description" data-vv-name="description"
                              placeholder="Enter description" v-validate="'required|min:5|max:100'"></textarea>
                    <span class="error-div">{{ errors.first('description') }}</span>
                </div>
                <button type="submit" class="btn btn-outline-dark">Create</button>
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
                description: ''
            }
        },
        methods: {
            storePost() {
                this.$validator.validate().then(valid => {
                    if (!valid) {
                        return false;
                    } else {
                        axios.defaults.headers.common["Authorization"] = `Bearer ${TokenService.getToken()}`;
                        axios.post('/posts', {
                            title: this.title,
                            description: this.description
                        }).catch((err) => {
                           console.log(err);
                        }).then(() => {
                            this.$router.push({name:'Posts'});
                        });
                    }
                })
            }
        }
    }
</script>

<style scoped>
    .error-div {
        color: red;
    }
</style>