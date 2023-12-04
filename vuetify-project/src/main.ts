/**
 * main.ts
 *
 * Bootstraps Vuetify and other plugins then mounts the App`
 */

// Plugins
import { registerPlugins } from '@/plugins'

// Components
import App from './App.vue'

// Composables
import { createApp } from 'vue'
import router from "../src/router/index";
import axios from "/src/utils/axios";
axios.defaults.baseURL = 'http://127.0.0.1:8000/api/';

const app = createApp(App)
app.config.globalProperties.$axios = axios
app.use(router);
registerPlugins(app)

app.mount('#app')
