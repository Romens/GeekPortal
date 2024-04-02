<template>
    <div class="register-view">
        <div class="container">
            <div class="row justify-content-center align-items-center vh-100">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <form @submit="onSubmit">
                                <div class="d-grid gap-2">
                                    <div
		                                    class="form-group"
                                        id="input-group-1"
                                        label-for="input-1"
                                        description="Find best username"
                                    >
                                        <input
                                            id="input-1"
                                            class="form-control text-center"
                                            v-model="form.name"
                                            type="text"
                                            placeholder="Enter username"
                                            required
                                        />
                                    </div>
                                    <div
		                                    class="form-group" id="email" label-for="email">
                                        <input class="text-center" id="email" v-model="form.email" type="email" placeholder="Enter email" required/>
                                    </div>
                                    <div
		                                    class="form-group" id="password" label-for="password">
                                        <input class="text-center" id="password" v-model="form.password" type="password" placeholder="Enter password" required
                                                   />
                                    </div>
                                    <button type="submit" class="btn btn-success d-block">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <div class="card">
                        <div >
                            <div class="d-grid gap-2">
                                <RouterLink to="/login" class="btn btn-primary">Log in</RouterLink>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style type="scss"></style>
<script setup lang="ts">
import {reactive, ref} from "vue";
import {useRouter} from "vue-router";
import Api from "@/api";
import {useUserStore} from "@/stores/user";

const userStore = useUserStore();

const form = reactive({
    email: '',
    password: '',
    password_confirmation: '',
    name: '',
})
const loading = ref(false)

const onSubmit = (event:any) => {
    event.preventDefault()
    loading.value = true;
    form.password_confirmation = form.password;
    Api.post('/register', form)
        .then(({ data }) => {
            window.localStorage.setItem('token', data.token)
            userStore.setUser(data.user);
            useRouter().push('/');
        })
        .catch(() => {

        })
    ;
}
</script>
