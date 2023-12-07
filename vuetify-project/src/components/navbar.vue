<template>
  <v-app-bar color="primary" density="compact">
    <template v-slot:prepend>
      <v-app-bar-nav-icon></v-app-bar-nav-icon>
    </template>
    <v-app-bar-title>Gym app</v-app-bar-title>
    <template v-slot:append>
      <v-btn v-if="isLoggedIn" icon="mdi-logout" @click="logout"></v-btn>
    </template>
  </v-app-bar>
</template>

<script setup lang="ts">

import {ref} from 'vue';
import {useRouter} from 'vue-router';
import axios from "axios";

const isLoggedIn = ref((localStorage.getItem('token') !== null));
const router = useRouter();

const logout = async () => {
  const logoutPost = await axios.post(`/logout`);
  localStorage.removeItem('token')
  localStorage.removeItem('user')

  try {
    await router.push('/login');
  } catch (error) {
    console.error('Error during logout redirection:', error);
  }

};
</script>
