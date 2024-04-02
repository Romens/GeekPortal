<template>
    <form class="create-post">
        <div class="row">
            <div class="col-lg-6 col-12 offset-lg-3">
                <form class="card my-lg-4" @submit="createPost">
                <div class="card-body">
                    <input v-model="title" :placeholder="$t('post.placeholder.title')" autofocus tabindex="0" class="form-control form-control-lg title"></input>
                </div>
                <div class="card-body">
                    <textarea v-model="text" required :placeholder="$t('post.placeholder.text')" autofocus tabindex="0" class="form-control form-control-lg focus-ring text"></textarea>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn p-3 my-2 w-100 btn-primary btn-lg">
                                <span v-if="!loading">{{$t('post.create')}}</span>
                                <loader v-if="loading"></loader>
                            </button>
                            <RouterLink class="btn p-3 my-2 w-100 btn-primary btn-lg" to="/posts">
                                {{$t('post.back')}}
                            </RouterLink>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </form>
</template>

<script setup lang="ts">
    import {ref} from 'vue';
    import Api from "@/api";
    import Loader from "@/components/Loader.vue";
    import ReactionButtons from "@/components/posts/ReactionButtons.vue";
    import Actions from "@/components/posts/Actions.vue";
    import {useRouter} from "vue-router";
    import router from "@/router/frontend_router_vue";

    const title = ref('');
    const text = ref('');
    const loading = ref(false);

    function createPost()
    {
        loading.value = true;
        Api
            .post('api/posts', {
                'text': text.value,
                'title': title.value,
            })
            .then(({data}) => {
                router.push('/posts')
                loading.value = false;
            })
            .catch(result => {
                loading.value = false;
                console.log(result);
            })
    }

    document.body.addEventListener('keydown', (event:any) => {
        if(event.key === "Enter" && (event.metaKey || event.ctrlKey)) {
            console.debug('User press Enter!')
            createPost()
        }
    });

</script>

<style scoped>
.text {
    font-size: 3rem;
    height: 50vh;
}

.title {

}


</style>
