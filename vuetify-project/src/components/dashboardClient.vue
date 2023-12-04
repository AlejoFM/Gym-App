<template>
  <router-link to="userRoutine" class="card-link">
  <v-card>
    <v-card-title><v-icon>{{ icon }}</v-icon>{{ title }}</v-card-title>
    <v-card-subtitle>
      {{ rol }}
    </v-card-subtitle>
    <v-card-subtitle>
      {{ value }}
    </v-card-subtitle>
  </v-card>
  </router-link>
</template>

<script>
export default {
  props: {
    title: String,
    icon: String,
    rol: String,
    value: [String, Number],
    userId: Number,
  },
  computed: {
    userRoutine(){
      return `dashboard/users/${this.userId}`;
    }
  }

};
</script>
