<template>
  <v-app>
    <v-layout>
      <v-app-bar
        color="primary"
        density="compact"
      >
        <template v-slot:prepend>
          <v-app-bar-nav-icon></v-app-bar-nav-icon>
        </template>
        <v-app-bar-title>Gym app</v-app-bar-title>
        <template v-slot:append>
          <v-btn icon="mdi-dots-vertical"></v-btn>
        </template>
      </v-app-bar>
    <v-main>
      <v-container fluid>
        <v-sheet>
      <v-row v-for="user in users" :key="user.id" justify="center">
        <v-col  md="6" middle>
          <dashboard-client :title=user.name icon="mdi-account" :rol="user.rol" :value="user.email" :user-id="user.id"/>
        </v-col>
      </v-row>
        </v-sheet>
      </v-container>
    </v-main>
  </v-layout>
  </v-app>
</template>

<script>
import dashboardClient from "@/components/dashboardClient.vue";
import axios from "axios";

export default {
  components: {
    dashboardClient,
  },
  data() {
    return {
      users : [],
    };
  },
  mounted() {
    this.fetchUserData();
  },
  methods: {
    async fetchUserData(){
      try {
        const response = await axios.get("dashboard/users");
        this.users = response.data;

        console.log(this.users);
      } catch (error){
        console.log(error);
      }
    }
  }
};
</script>
