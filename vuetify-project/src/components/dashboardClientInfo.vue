<template>
  <v-app>
    <v-layout>
      <navbar></navbar>
      <v-main>
    <h2>Rutina del Usuario</h2>
    <template v-for="routine in routines" :key="routine.id">
      <v-table>
        <thead>
        <tr>
          <th>Día</th>
          <th>Ejercicio</th>
          <th>Repetitions</th>
          <th>Series</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(routine_exercise_info, index) in routine.routine_exercise" :key="routine_exercise_info.id">
          <template v-if="index === 0 || routine_exercise_info.routine_id !== routine.routine_exercise[index - 1].routine_id">
            <td>{{ routine.train_day }} </td>
          </template>
          <template v-else>
            <td></td>
          </template>
          <td>

            <v-select v-model="selectedExercise[routine_exercise_info.id]" :items="exerciseNames" item-title="name" item-value="id"></v-select>
          </td>
          <td>  <v-text-field v-model="repetitions[routine_exercise_info.id]" ></v-text-field> </td>
          <td>  <v-text-field v-model="series[routine_exercise_info.id]" ></v-text-field></td>
          <td> <v-btn @click="deleteExerciseRoutine(routine_exercise_info.id)" class="bg-red">DELETE</v-btn></td>
        </tr>
        </tbody>
        <v-btn @click="updateExerciseRoutine" class="bg-blue"></v-btn>
      </v-table>
    </template>
      <create-user-routine-modal></create-user-routine-modal>
      </v-main>
      </v-layout>
  </v-app>
</template>

<script>
import Navbar from "@/components/navbar.vue";
import router from "@/router";
import RepetitionsTextField from "@/components/repetitions-text-field.vue";
import SeriesTextField from "@/components/series-text-field.vue";
import CreateUserRoutineModal from "@/components/createUserRoutineModal.vue";

export default {
  components: {CreateUserRoutineModal, SeriesTextField, RepetitionsTextField, Navbar},
  data() {
    return {
      routines: [],
      exerciseNames: [],
      exerciseVolume: [],
      selectedExercise: {},
      updatedSeries: {},
      series: {},
      repetitions: {},
    };
  },
  mounted() {
    this.fetchRoutine();
    this.fetchExercise();
    this.updateExerciseRoutine();

  },
  methods: {
    router() {
      return router
    },
    async fetchRoutine() {
      const userId = this.$route.params.user_id;
      try {
        const response = await this.$axios.get(`/dashboard/user_routine/${userId}`);
        this.routines = response.data;
        console.log(this.routines)
        this.routines.forEach((routine) => {
          routine.routine_exercise.forEach((routineExercise) => {
            this.selectedExercise[routineExercise.id] = routineExercise.exercise.id;
            this.exerciseVolume[routineExercise.id] = routineExercise.training_volume.id;
            this.series[routineExercise.id] = routineExercise.training_volume.series;
            this.repetitions[routineExercise.id] = routineExercise.training_volume.repetitions
          });
      })} catch (error) {
        console.error('Error al obtener la rutina:', error);
      }
    },
    async fetchExercise(){
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
    },
    async updateExerciseRoutine(){
      try {
        const updatedExercises = [];
        console.log(this.routines)
        this.routines.forEach((routine) => {
          routine.routine_exercise.forEach((routine_exercise) => {
            const selectedExercise = this.selectedExercise[routine_exercise.id];
            const updatedExerciseVolumeId = this.exerciseVolume[routine_exercise.id];
            const updatedExerciseRepetitions = this.repetitions[routine_exercise.id];
            const updatedExerciseSeries = this.series[routine_exercise.id];
            if (selectedExercise !== null) {
              updatedExercises.push({
                routineExerciseId:  routine_exercise.id,
                updatedExerciseId: selectedExercise,
                updatedExerciseVolumeId: parseInt(updatedExerciseVolumeId),
                updatedExerciseRepetitions: parseInt(updatedExerciseRepetitions),
                updatedExerciseSeries: parseInt(updatedExerciseSeries)
              });
            }
          });
        });
          console.log(updatedExercises)
        const response = await this.$axios.put('/dashboard/exercise', { updatedExercises });

        // Recupera los IDs actualizados del servidor
        const updatedIds = response.data.updatedExercises;
        console.log('IDs actualizados:', updatedIds);

      } catch (error) {
        console.error('Error al enviar los cambios:', error);
      }
    },
    async deleteExerciseRoutine(id){
      console.log(id);
      try {
        const userId = this.$route.params.user_id;
        let routineExerciseId;
        this.routines.forEach((routine) => {
          routine.routine_exercise.forEach((routine_exercise) => {
            const selectedExercise = this.selectedExercise[routine_exercise.id];
            if (selectedExercise !== null) {
              routineExerciseId = routine_exercise.id
            }
          });
        });
        const response = await this.$axios.delete(`/dashboard/exercise`, {data: { exerciseId: id }})

        await this.fetchRoutine();

      } catch (error) {
        console.error('Error al enviar los cambios:', error);
      }
    },
  },
};
</script>

<style>
/* Estilos opcionales para tu tabla */
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

th, td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #f2f2f2;
}
</style>
