<template>
  <div>
    <v-text-field :v-model="series" :label="exercise_series" hide-details="auto" :exercise_id="exercise_id"></v-text-field>
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
    exercise_series: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      series: {},
    };
  },
  mounted() {
    this.fetchVolumeSeries(this.exercise_id);
    this.series = this.exercise_series;
  },
  methods: {
    router() {
      return router
    },
    async updateRoutine(){
      this.$emit("updateSeries", this.series)
    },
    async fetchVolumeSeries(exercise_id) {
      console.log(exercise_id)
      try {
        const response = await this.$axios.get(`/dashboard/exercise/volume/${exercise_id}`);
        this.routines = response.data;
        this.series = response.data.volume.series;
        console.log(this.series)
      } catch (error) {
        console.error('Error al obtener la rutina:', error);
      }
    },
  },
};
</script>
