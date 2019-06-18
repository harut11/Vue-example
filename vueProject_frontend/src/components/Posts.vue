<template>
    <div class="container">
        <div class="box-content">
            <button type="button" class="create-btn btn btn-outline-dark" @click="createPost()">Create new</button>
                <div v-if="posts" class="posts">
                    <div v-for="post in posts" class="col-md-4">
                        <div class="card item">
                            <div class="row m-auto w-100" v-if="post.user_id === user.id">
                                <button type="button" class="btn btn-warning w-25 mr-2" @click="editPost(post.id)"><i class="fas fa-pen"></i></button>
                                <button type="button" class="btn btn-danger w-25" @click="deletePost(post.id)"><i class="fas fa-trash"></i></button>
                            </div>
                            <div class="card-body">
                                <a href="" @click.prevent="showPost(post)" v-b-modal.my-modal><h3 class="post-title card-title">{{ post.title }}</h3></a>
                                <p class="post-description card-text">{{ post.description.length>10?post.description.substr(0, 10)+' ...':post.description }}</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">{{ post.created_at }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            <infinite-loading spinner="waveDots" @infinite="showPosts"></infinite-loading>
            <b-modal id="my-modal" title="BootstrapVue">
                <div v-if="selectedPost">
                    <h1>
                        {{ selectedPost.title }}
                    </h1>
                    <p>{{ selectedPost.description }}</p>
                </div>
            </b-modal>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import InfiniteLoading from 'vue-infinite-loading';

    export default {
        data() {
            return {
                posts: [],
                selectedPost: null,
                user: null,
                page: 1
            }
        },
        methods: {
            createPost() {
                this.$router.push({name:'CreatePost'});
            },
            editPost(id) {
                this.$router.push({name:'EditPost', params: { id: id }});
            },
            deletePost(id) {
                axios.delete('posts/' + id).catch((err) => {
                    console.log(err);
                }).then((res) => {
                    if (res) {
                        this.posts.forEach((item) => {
                            if (item.id === id) {
                                this.posts.splice(this.posts.indexOf(item), 1);
                            }
                        });
                    }
                });

            },
            showPost(post) {
                this.selectedPost = post
            },
            showPosts($state) {
                axios.get('posts', {
                    params: {
                        page: this.page,
                    },
                }).then(({ data }) => {
                    if (data.posts.data.length) {
                        this.page += 1;
                        this.posts.push(...data.posts.data);
                        this.$store.commit('setTestData', data.posts.data);
                        $state.loaded();
                    } else {
                        $state.complete();
                    }
                });
                this.user = this.$store.getters['getUserData'];
            }
        },
        computed: {

        },
        components: {
            InfiniteLoading,
        },
    }
</script>

<style scoped>
    .create-btn {
        margin-bottom: 50px;
    }
</style>