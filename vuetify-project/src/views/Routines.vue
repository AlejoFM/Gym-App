<template>
  <div>
    <h2>Rutina del Usuario</h2>
    <table>
      <thead>
      <tr>
        <th>Día</th>
        <th>Ejercicio</th>
        <th>Repetitions</th>
        <th>Series</th>
      </tr>
      </thead>
      <tbody>
      <template v-for="routine in routines" :key="routine.id">
        <tr v-for="(routine_exercise_info, index) in routine.routine_exercise" :key="routine_exercise_info.id">
          <template v-if="index === 0 || routine_exercise_info.routine_id !== routine.routine_exercise[index - 1].routine_id">
            <td>{{ routine.train_day }}</td>
          </template>
          <template v-else>
            <td></td> <!-- Campo vacío si el día se repite -->
          </template>
          <td>{{ routine_exercise_info.exercise.name }}</td>
          <td>{{ routine_exercise_info.volume.repetitions }}</td>
          <td>{{ routine_exercise_info.volume.series }}</td>
        </tr>
      </template>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      routines: [],
      exercise: 0,
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
        if (this.routines.train_day){
          exercise++;
        }
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
