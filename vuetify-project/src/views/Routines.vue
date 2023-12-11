<template>
  <v-app>
    <v-layout>
      <navbar></navbar>
      <v-main>
        <h2>Rutina del Usuario</h2>
        <template v-for="routine in routines" :key="routine.id">
          <table v-if="routine.routine_exercise.length > 0">
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
              <template
                v-if="index === 0 || routine_exercise_info.routine_id !== routine.routine_exercise[index - 1].routine_id">
                <td>{{ routine.train_day }}</td>
              </template>
              <template v-else>
                <td></td>
              </template>
              <td>{{ routine_exercise_info.exercise.name }}</td>
              <td>{{ routine_exercise_info.training_volume.repetitions }}</td>
              <td>{{ routine_exercise_info.training_volume.series }}</td>
            </tr>
            </tbody>
          </table>
        </template>
      </v-main>
    </v-layout>
  </v-app>
</template>

<script>
import Navbar from "@/components/navbar.vue";

export default {
  components: {Navbar},
  data() {
    return {
      routines: [],
    };
  },
  mounted() {
    this.fetchRoutine();
  },
  methods: {
    async fetchRoutine() {
      // Realiza una solicitud GET al endpoint correspondiente
      try {
        const response = await this.$axios.get('myroutine'); // Ajusta la URL según tu configuración

        this.routines = response.data.user;

        console.log(this.routines);

      } catch (error) {
        console.error('Error al obtener la rutina:', error);
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
