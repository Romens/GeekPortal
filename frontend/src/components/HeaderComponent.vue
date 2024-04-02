<template>
    <header class="fixed-top">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="#" :title="$t('header.navbar_title')">
                    <img v-show="logo" class="navbar-brand" data-bs-theme="dark" :src="logo" />
                    <span v-show="!logo">{{$t('header.navbar_title')}}</span>
                </a>
                <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbar2Label">Offcanvas</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                            <li class="nav-item">
                                <RouterLink activeClass="active" class="nav-link" to="/">{{ $t('header.home_title') }}</RouterLink>
                            </li>
                            <li class="nav-item">
	                            <RouterLink activeClass="active" class="nav-link" to="/posts">
		                            {{ $t('header.post_title') }}
	                            </RouterLink>
                            </li>
                            <li class="nav-item">
                                <RouterLink activeClass="active" class="nav-link" to="/about">{{ $t('header.about_title') }}</RouterLink>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="d-flex">
                    <router-link v-show="!user.isAuth" to="/login" class="btn btn-primary">{{$t('auth.login')}}</router-link>
                    <div class="btn-group" v-show="user.isAuth" >
                        <div class="btn btn-primary">👤 {{ user.name }}</div>
                        <button type="button" @click="logout" class="btn btn-primary"> {{$t('auth.logout')}} </button>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</template>

<script setup lang="ts">
import {useUserStore} from '@/stores/user';
import {RouterLink} from 'vue-router';
import router from "@/router/frontend_router_vue";

import { ref } from "vue";
const user = useUserStore();
const logo = ref(window.appSettings.appUrl + 'images/Logo Wide White.svg');

function logout() {
    user.logout();
    router.push('/')
}


</script>

<style scoped>
</style>
