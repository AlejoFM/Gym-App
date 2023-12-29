<template>
  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      persistent
      width="1024"
    >
      <template v-slot:activator="{ props }">
        <v-btn
          color="primary"
          v-bind="props"
        >
          Crear Dia de Entrenamiento
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="text-h5">Dia de entrenamiento</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row class="d-flex justify-content-around">
              <v-col cols="12">
                <v-select type="select" v-model="this.routine.training_day" :items="dias" label="Dia" placeholder="Selecciona un día"
                          required>
                </v-select>
              </v-col>
              <v-col cols="12">
                <v-select
                  label="Ejercicio"
                  v-model="this.routine.exercise_id"
                  :items="exerciseNames"
                  item-title="name"
                  item-value="id"
                >
                </v-select>              </v-col>
              <v-col cols="12">
                <v-text-field
                  label="Repeticiones"
                  v-model="this.routine.exercise_repetitions"
                  required
                ></v-text-field>
              </v-col>
              <v-col>
                <v-text-field
                  label="Series"
                  v-model="this.routine.exercise_series"
                  required
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue-darken-1"
            variant="text"
            @click="dialog = false"
          >
            Close
          </v-btn>
          <v-btn
            color="blue-darken-1"
            variant="text"
            @click="dialog = false; createNewRoutine();"
          >
            Upload
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import axios from "axios";

export default {
  data: () => ({
    dialog: false,

    dias: [
      "lunes",
      "martes",
      "miercoles",
      "jueves",
      "viernes",
      "sabado",
      "domingo"
    ],
    exercises: [
      {id: "",
      name: "",}
    ],
    exercisesArray: [],
    exerciseNames: [],
    routine: {
      exercise_id: "",
      exercise_repetitions: "",
      exercise_series: "",
      training_day: "",
      user_id: "",
    },
    errors: {},
  }),
  mounted(){
      this.fetchAllExercises()


  },
  methods: {
    async createNewRoutine() {
      try {
        const userId = this.$route.params.user_id
        this.routine.user_id = parseInt(userId);

        console.log(this.routine)
        const response = await axios.post("/dashboard/generateroutine/", this.routine)
        console.log(response)
      } catch (error) {
        if (error.response && error.response.data) {
          console.log(error.response);
        }
      }
    },
    async fetchAllExercises() {
      try {
        const response = await this.$axios.get(`/dashboard/exercise`);
        this.exerciseNames = this.extractExerciseNames(response.data.exercises);

      } catch (error) {
        console.error('Error al obtener los nombres de ejercicios:', error);
      }
    },
    extractExerciseNames(data) {
      if (Array.isArray(data)) {
        return data.map((exercise) => ({'name': exercise.name, 'id': exercise.id}));

      } else if (typeof data === 'object' && data !== null) {
        if ('exercises' in data && Array.isArray(data.exercises)) {
          return data.exercises.map((exercise) => exercise.name);
        } else if ('name' in data) {
          return [data.name];
        }
      }
      return [];
    }
  }
}
</script>
