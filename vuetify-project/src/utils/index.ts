import axios from 'axios';
import router from '../router/index';

declare module '*.vue';
axios.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('token');
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
        if (error.response.data.message === "No tienes permiso para acceder a esta ruta") {
          router.push('unauthorized');
        }else if(error.response.data.message == "Fecha de token inválida")
              localStorage.removeItem('token');
              localStorage.removeItem('user');

              router.push('unauthorized').then(() => {
                setTimeout(() => {
                  router.push('login');
                }, 3000)
            });
        return Promise.reject(error);
    }
);

export default axios
