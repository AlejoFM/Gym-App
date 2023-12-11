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
          Create Exercise
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="text-h5">Create a new Exercise 🏋️‍♂️</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
                <v-text-field
                  v-model="exerciseName"
                  label="Exercise name*"
                  required
                ></v-text-field>
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
            @click="createNewExercise"
          >
            create
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
export default {
  data() {
    return {
      dialog: false,
      exerciseName: '',
    };
  },
  methods: {
    createNewExercise() {
      // Emite un evento "create-exercise" con el nombre del ejercicio
      console.log(this.exerciseName)
      this.$emit('create-exercise', this.exerciseName);
      // Cierra el modal
      this.dialog = false;
    }
  }
}
</script>
