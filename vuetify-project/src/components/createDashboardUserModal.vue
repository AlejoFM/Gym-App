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
          Crear Usuario
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="text-h5">User Profile</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row class="d-flex justify-content-around">
              <v-col><v-text-field label="Name Client*" v-model="user.name" placeholder="User Name" required ></v-text-field></v-col>
              <v-col>
                <v-text-field label="Last name Client" v-model="user.surname" hint="example of helper text only on focus"></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  label="Email*" v-model="user.email"
                  required
                ></v-text-field>
              </v-col>
              <v-col>
                <v-text-field
                  label="Password*"
                  type="password" v-model="user.password"
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
            @click="dialog = false; createNewUser();"
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
    user: {
      email: "",
      name: "",
      password: "",
      surname: "",
    },
    errors: {}
  }),
  methods: {
    async createNewUser() {
      try {
        const response = await axios.post("dashboard/users", this.user)
        console.log(response)
      } catch (error) {
        if (error.response && error.response.data) {
          console.log(error.response.data.errors);
        }
      }
    }
  }
}
</script>
