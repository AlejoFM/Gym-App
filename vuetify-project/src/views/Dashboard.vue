<template>
  <v-app>
    <v-container>
      <v-row v-for="user in users" :key="user.id">
        <v-col cols="12" md="4">
          <dashboard-client :title=user.name icon="mdi-account" :rol="user.rol" :value="user.email" />
        </v-col>

      </v-row>
    </v-container>
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
