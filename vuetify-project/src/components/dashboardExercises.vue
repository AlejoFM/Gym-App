<template>
  <v-app>
    <v-layout>
      <navbar></navbar>
      <v-main>
        <v-container fluid v-for="exercise_muscular_group in exercise_muscular_groups" :key="exercise_muscular_group.id">
          <v-sheet>
            <router-link :to="'exercises/'+exercise_muscular_group.muscular_group" class="card-link">
            <v-row  justify="center" >
              <v-card>
                <v-card-title><v-icon icon="mdi-card-multiple"></v-icon>{{ exercise_muscular_group.muscular_group}}</v-card-title>
              </v-card>
            </v-row>
              </router-link>
          </v-sheet>
        </v-container>
      </v-main>
    </v-layout>
  </v-app>
</template>
<script>
import router from "@/router";
import navbar from "@/components/navbar.vue";
import dashboardClient from "@/components/dashboardClient.vue";

export default {
  components: { navbar},

  data() {
    return {
      exercise_muscular_groups: [],
    };
  },
  mounted() {
    this.fetchExercise();
  },
  methods: {
    router() {
      return router
    },
    async fetchExercise() {
      try {
        const response = await this.$axios.get(`/dashboard/muscular_group`);
        console.log(response)
        this.exercise_muscular_groups = (response.data.muscular_group);

      } catch (error) {
        console.error('Error al obtener los nombres de ejercicios:', error);
      }
    },
  }
}
</script>
