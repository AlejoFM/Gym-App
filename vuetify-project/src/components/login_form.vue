<template>
  <v-sheet width="300" class="mx-auto">
    <v-form fast-fail @submit.prevent="login">
      <v-text-field
        v-model="email"
        label="Email"
      ></v-text-field>

      <v-text-field
        v-model="password"
        label="Last name"
      ></v-text-field>

      <v-btn type="submit" block class="mt-2">Submit</v-btn>
    </v-form>
  </v-sheet>
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
      router.push('/');
    }

    const login = () => {
      axios.post('http://127.0.0.1:8000/api/login', { email: email.value, password: password.value })
        .then((response) => {
          try {
            if (response.data) {
              const token = response.data.token;
              const user = response.data.user;
              localStorage.setItem('token', token);
              localStorage.setItem('user', JSON.stringify(user));
              if (user.rol === "admin"){
                router.push('/dashboard');
              }else{
                router.push('/');
              }
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

