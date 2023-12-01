import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import axios from './utils/axios'
import router from "./router/index";

axios.defaults.baseURL = 'http://127.0.0.1:8000/api/';

const app = createApp(App)
app.config.globalProperties.$axios = axios
app.use(router)
app.mount('#app')
