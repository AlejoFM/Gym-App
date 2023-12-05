<template>
  <v-data-table-server
    v-model:items-per-page="itemsPerPage"
    :headers="headers"
    :items-length="totalItems"
    :items="serverItems"
    :loading="loading"
    :search="search"
    item-value="train_day"
    @update:options="loadItems"
  ></v-data-table-server>
</template>

<script>
import axios from "axios";

export default {
  data: () => ({
    itemsPerPage: 3,
    headers: [
      { title: 'Día', key: 'train_day', align: 'start' },
      { title: 'Ejercicio', key: 'exercise', align: 'start' },
      { title: 'Repetitions', key: 'repetitions', align: 'end' },
      { title: 'Series', key: 'series', align: 'end' },
    ],
    search: '',
    serverItems: [],
    loading: true,
    totalItems: 0,
  }),
  methods: {
    async loadItems ({ page, itemsPerPage, sortBy }) {
      this.loading = true;
      const userId = this.$route.params.user_id;
      try {
        const response = await axios.get(`dashboard/user_routine/${userId}`);
        const routines = response.data;
        // Ajusta la estructura de los datos según los requerimientos del v-data-table-server
        const items = routines.reduce((acc, routine) => {
          routine.routine_exercise.forEach((routine_exercise, index) => {
            const item = {
              train_day: index === 0 ? routine.train_day : '',
              exercise: routine_exercise.exercise.name,
              repetitions: routine_exercise.volume.repetitions,
              series:  routine_exercise.volume.series,
            };
            acc.push(item);
          });
          return acc
        }, []);
        console.log(items);

        this.totalItems = items.length;

        // Implementa la lógica de ordenamiento si es necesario
        if (sortBy.length) {
          const sortKey = sortBy[0].key;
          const sortOrder = sortBy[0].order;
          items.sort((a, b) => {
            const aValue = a[sortKey];
            const bValue = b[sortKey];
            return sortOrder === 'desc' ? bValue - aValue : aValue - bValue;
          });
        }

        // Pagina los resultados
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        this.serverItems = items.slice(start, end);

        this.loading = false;
      } catch (error) {
        console.error('Error al obtener la rutina:', error);
        this.loading = false;
      }
    },
  },
};
</script>
