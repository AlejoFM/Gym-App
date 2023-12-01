<template>
  <main>
    <table>
      <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Content</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="project in projects" :key="project.id">
        <td>{{ project.id }}</td>
        <td>{{ project.title }}</td>
        <td>{{ project.content }}</td>
      </tr>
      </tbody>
    </table>
  </main>
</template>
<script>

import axios from "axios";
import { onMounted, ref } from "vue";

export default {
  setup() {
    let projects = ref([]);

    onMounted(() => {
      axios.get('http://127.0.0.1:8000/api/projects')
          .then((response) => {
            try {
              if (response.data) {
                  projects.value = response.data;
                  console.log('Projects:', projects.value);
                }
              else {
                console.error('Invalid API response - No data:', response);
              }
            } catch (error) {
              console.error('Error parsing JSON:', error);
              console.error('Response data:', response.data);
            }
          })
          .catch((error) => {
            console.error('Error fetching projects:', error);
          });
    });

    return {
      projects,
    };
  }
}
</script>