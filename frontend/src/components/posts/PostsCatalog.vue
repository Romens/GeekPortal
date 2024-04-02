<template>
    <div class="posts-catalog">
        <div class="d-grid">
            <div class="card mx-1 my-2 border-0">
                <input type="search" class="form-control form-control-lg" @keyup="search" @change="search" v-model="queryString" name="search" autofocus :placeholder="$t('post.search')" />
            </div>
            <div class="card mx-1 my-2 border-0" v-show="!loading && posts.length === 0">
                <div class="card-body">
                    <h3 class="display-4">{{ $t('post.not_found') }}</h3>
                </div>
            </div>
            <div class="masonry-row">
                <div class="masonry-col" :key="indexKey" v-for="(post, indexKey) in posts">
                    <CardTextPost :key="post.id" :post="post"></CardTextPost>
                </div>
            </div>
            <div v-show="loading" class="text-center p-3">
                <Loader></Loader>
            </div>
        </div>
        <actions v-if="isAuth"></actions>
    </div>
</template>

<script type="module" setup lang="ts">
    import { ref } from 'vue';
    import { storeToRefs } from "pinia";

    import Api from "@/api";
    import Loader from "@/components/Loader.vue";
    import Actions from "@/components/posts/Actions.vue";
    import { useUserStore } from "@/stores/user";
		import CardTextPost from "@/components/posts/types/CardTextPost.vue";

    const posts = ref([] as any[any]);
    const loading = ref(false);
    const page = ref(0);
    const lastPage = ref(1);
    const queryString = ref(localStorage.getItem('posts_search_query_string') || '');
    const { isAuth } = storeToRefs(useUserStore());

    function loadPosts() {
        if (page.value >= lastPage.value || loading.value) {
            console.debug('This is last page posts or loading new data');
            return
        }
        page.value = page.value + 1;
        loading.value = true
        Api
            .post('/api/posts?page=' + page.value, {
                'search': queryString.value,
            })
            .then(({data}) => {
                const newPosts = data.data;
                lastPage.value = data.meta.last_page
                posts.value.push(...newPosts)
                loading.value = false
            })
            .catch(({err}) => {
                loading.value = false
            })
    }

    function reset() {
        page.value = 0;
        lastPage.value = 1;
    }

    function search() {
        if (queryString.value.length > 2) {
            localStorage.setItem('posts_search_query_string', queryString.value);
            reset();
            loadPosts();
        } else {
            localStorage.removeItem('posts_search_query_string');
            reset();
            loadPosts();
        }
    }


    window.onscroll = function(ev) {
        console.log(
            window.innerHeight,
            window.scrollY,
            document.body.offsetHeight
        );
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
            loadPosts();
            console.info("you're at the bottom of the page");
        }
    };

    window.Echo
        .join('chat')
        .listen('.post.created', (event:any) => {
            posts.value.unshift(event.post as never);
            console.info('New post: "' + event.post.title + '"!');
        });


    loadPosts();
</script>

<style scoped>
.masonry-row {
    -moz-column-width: 18em;
    -webkit-column-width: 18em;
    -moz-column-gap: 1em;
    -webkit-column-gap:1em;
}

.masonry-col {
    display: inline-block;
    padding:  .25rem;
    width:  100%;
}

</style>
