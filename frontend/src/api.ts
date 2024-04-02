import axios from "axios";
import {useRouter} from "vue-router";

const Api = axios.create({
    baseURL: "http://localhost",
    withCredentials: true,
});


const token = window.localStorage.getItem("token");
const csrf_token = window.localStorage.getItem("csrf_token");
Api.interceptors.request.use(config => {
    if (token) config.headers["Authorization"] = `Bearer ${token}`;
    if (csrf_token) config.headers["X-CSRF-TOKEN"] = csrf_token;
    return config
})
Api.interceptors.response.use(response => {
    return response;
}, error => {
    if (error.response.status === 401) {
        window.location.replace('/login')
    }
    return error;
});

export default Api
