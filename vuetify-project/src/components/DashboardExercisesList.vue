<template>
  <v-app>
    <v-layout>
      <navbar></navbar>
      <v-main>
        <v-container fluid v-for="exercise_muscular_group in exercise_muscular_groups" :key="exercise_muscular_group.id">
        <v-sheet>
              <v-row  justify="center" >
                <template v-if="!isEditing">
                  <v-card >
                    <v-card-title><v-icon icon="mdi-tune"></v-icon>{{ exercise_muscular_group.name }}</v-card-title>
                  </v-card>
                </template>
                <template v-else>
                  <v-text-field v-model="exercise_muscular_group.name"></v-text-field>
                  <v-btn @click="stopEditing" class="bg-amber">Finish edit</v-btn>
                </template>
              </v-row>
          </v-sheet>
          </v-container>

        <v-row justify="center" align="center">
          <v-col cols="auto">
            <create-exercise-modal @create-exercise="handleCreateExercise"></create-exercise-modal>
          </v-col>
          <v-col cols="auto" v-if="!isEditing">
          <v-btn class="bg-amber" @click="startEditing(exercise_muscular_group)" >Edit</v-btn>
          </v-col>
        </v-row>
      </v-main>
    </v-layout>
  </v-app>
</template>
<script>
import router from "@/router";
import navbar from "@/components/navbar.vue";
import dashboardClient from "@/components/dashboardClient.vue";
import CreateExerciseModal from "@/components/createExerciseModal.vue";

export default {
  components: {CreateExerciseModal, dashboardClient, navbar},
  data() {
    return {
      exercise_muscular_groups: [],
      isEditing: false,
      newExerciseNames: [],
    };
  },
  mounted() {
    this.fetchExercise();
  },
  methods: {
    router() {
      return router
    },
    startEditing(exercise){
      this.isEditing = true;
    },
    stopEditing(){
      this.isEditing= false;
      const response = this.exercise_muscular_groups;
      const muscular_groups_name = this.$route.params.exercise_muscular_group;

      response.forEach(() => {
        this.newExerciseNames = response;
      });
      const ExerciseNames = this.newExerciseNames;
      this.$axios.put(`/dashboard/muscular_group/`, { ExerciseNames })
    },
    async fetchExercise() {
      try {
        const muscular_groups_name = this.$route.params.exercise_muscular_group;
        const response = await this.$axios.get(`/dashboard/muscular_group/${muscular_groups_name}`);
        this.exercise_muscular_groups = response.data.data;

      } catch (error) {
        console.error('Error al obtener los nombres de ejercicios:', error);
      }
    },
    handleCreateExercise(exerciseName) {
      // Maneja el evento "create-exercise" aquí
      console.log(`Nuevo ejercicio creado: ${exerciseName}`);
      const muscular_groups_name = this.$route.params.exercise_muscular_group;
      const exerciseData = {
        name: exerciseName,
        muscular_groups_name: muscular_groups_name
      }
      this.$axios.post(`/dashboard/muscular_group/`, {exerciseData})
    },
  }
}
</script>
