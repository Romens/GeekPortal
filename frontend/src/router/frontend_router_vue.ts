import {createRouter, createWebHistory} from 'vue-router'
import HomeView from '../views/HomeView.vue'

// POST
import ViewPosts from '../views/posts/ViewPosts.vue'
import CreatePost from '../views/posts/CreatePost.vue'

import LoginView from "../views/LoginView.vue";
import RegisterView from "../views/RegisterView.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/posts',
            name: 'posts',
            component: ViewPosts
        },
        {
            path: '/posts/create',
            name: 'posts.create',
            component: CreatePost
        },
        {
            path: '/',
            name: 'home',
            component: HomeView
        },
        {
            name: 'login',
            path: '/login',
            component: LoginView
        },
        {
            name: 'register',
            path: '/register',
            component: RegisterView
        },
        {
            path: '/about',
            name: 'about',
            // route level code-splitting
            // this generates a separate chunk (About.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import('../views/AboutView.vue')
        }
    ]
})

export default router
