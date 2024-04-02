<template>
  <div class="login-view">
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <form @submit="onSubmit" v-if="show">
                            <div class="d-grid gap-2">
                                <div class="form-group">
                                    <input
                                        class="form-control text-center"
                                        v-model="form.email"
                                        type="email"
                                        :placeholder="$t('auth.email_placeholder')"
                                        required
                                    />
                                </div>
                                <div class="form-group" id="password">
                                    <input class="text-center form-control" id="password" v-model="form.password" type="password" :placeholder="$t('auth.password_placeholder')" required/>
                                </div>
                                <button :disabled="loading" type="submit" class="btn btn-primary d-block">
                                    <span  v-show="!loading">{{$t('auth.login')}}</span>
                                    <loader v-show="loading"></loader>
                                </button>
                                <RouterLink to="/restore-password" class="btn btn-link">{{ $t('auth.restore') }}</RouterLink>
                            </div>
                        </form>
                    </div>
                </div>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <RouterLink to="/register" class="btn btn-success">{{ $t('auth.register') }}</RouterLink>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<style></style>
<script setup lang="ts">
import {nextTick, reactive, ref} from "vue";
import Api from "@/api";
import router from "@/router/frontend_router_vue";
import { useUserStore } from "@/stores/user";
import Loader from "@/components/Loader.vue";

const form = reactive({
    email: 'demo@example.com',
    password: 'demo',
})
const show = ref(true)
const loading = ref(false)
const user = useUserStore();

const onSubmit = (event:any) => {
    event.preventDefault()
    loading.value = true;
    Api.post('/login', form)
        .then((data) => {
            const token = data.data.token;
            const csrf_token = data.data.csrf_token;
            user.setUser(data.data.user);
            window.localStorage.setItem('token', token)
            window.localStorage.setItem('csrf_token', csrf_token)
            router.back();
            loading.value = false;
        })
        .catch(() => {
            loading.value = false;
        });

}
</script>
