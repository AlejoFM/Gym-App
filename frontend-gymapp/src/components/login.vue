<template>
  <form @submit.prevent="login">
    <div>
      <input type="email" v-model="email" placeholder="Email">
    </div>
    <div>
      <input type="password" v-model="password" placeholder="Password">
    </div>
    <div>
      <button type="submit">Login</button>
    </div>
  </form>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import router from "@/router";

export default {
  setup() {
    const email = ref("");
    const password = ref("");
    const user = ref([]);
    if (localStorage.getItem("token") != null){
      router.push('/projects');
    }
    const login = () => {
      axios.post('http://127.0.0.1:8000/api/login', { email: email.value, password: password.value })
          .then((response) => {
            try {
              if (response.data) {
                user.value = response.data;
                console.log('User:', user.value);
                localStorage.setItem("token", response.data);
              } else {
                console.error('Invalid API response - No data:', response);
              }
            } catch (error) {
              console.error('Error parsing JSON:', error);
              console.error('Response data:', response.data);
            }
          })
          .catch((error) => {
            console.error('Error logging in:', error);
          });
    };


    return {
      email,
      password,
      login,
    };
  },
};
</script>
