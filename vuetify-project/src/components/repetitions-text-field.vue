<template>
  <div>
    <v-text-field :v-model="repetitions" :label="exercise_repetitions" hide-details="auto" :exercise_id="exercise_id"></v-text-field>
  </div>
</template>
<script>
import Navbar from "@/components/navbar.vue";
import router from "@/router";

export default {
  props: {
    exercise_id: {
      type: Number,
      required: true,
    },
    exercise_repetitions: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      repetitions: {},
    };
  },
  mounted() {
    this.fetchVolumeRepetitions(this.exercise_id);
    this.repetitions = this.exercise_repetitions;
  },
  methods: {
    router() {
      return router
    },
    async fetchVolumeRepetitions(exercise_id) {
      console.log(exercise_id)
      try {
        const response = await this.$axios.get(`/dashboard/exercise/volume/${exercise_id}`);
        this.routines = response.data;
        this.repetitions = response.data.volume.repetitions;
        console.log(this.repetitions)
      } catch (error) {
        console.error('Error al obtener la rutina:', error);
      }
    },
  },
};
</script>
