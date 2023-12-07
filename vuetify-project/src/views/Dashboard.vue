<template>
  <v-app>
    <v-layout>
      <navbar></navbar>
    <v-main>
      <v-container fluid>
        <v-sheet>
      <v-row v-for="user in users" :key="user.id" justify="center" >
        <template v-if="user.rol === 'client'">
          <v-col  md="6" middle >
            <dashboard-client :title=user.name icon="mdi-account" :rol="user.rol" :value="user.email" :user-id="user.id"/>
          </v-col>
          <div class="d-flex flex-column">
            <v-btn :to="'dashboard/users/'+user.id" class="bg-red"></v-btn>
            <v-btn :to="'dashboard/users/'+user.id" class="bg-blue"></v-btn>
            <v-btn :to="'dashboard/users/'+user.id" class="bg-green"></v-btn>
          </div>
        </template>
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
import Navbar from "@/components/navbar.vue";

export default {
  components: {
    Navbar,
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
