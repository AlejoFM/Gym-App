import axios from 'axios';
import router from '../router/index';

axios.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('token');
        const user = localStorage.getItem('user');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

axios.interceptors.response.use(
    (response) => {
        return response;
    },
    (error) => {
        if (error.response.status === 401) {
            router.push('unauthorized');
        }
        return Promise.reject(error);
    }
);
export default axios;
