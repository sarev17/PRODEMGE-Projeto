<template>
  <v-sheet class="mx-auto" width="300">
    <v-form @submit.prevent="submitForm"> <!-- Adicionando o manipulador de evento submitForm -->
      <v-text-field
        v-model="firstName"
        :rules="rules"
        label="First name"
      ></v-text-field>
      <v-btn class="mt-2" type="submit" block>Submit</v-btn>
    </v-form>
  </v-sheet>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      firstName: '',
      rules: [
        value => {
          if (value) return true
          return 'You must enter a first name.'
        },
      ],
    };
  },
  methods: {
    submitForm() {
      axios.post('')
    }
  }
}
</script>
