<template>
  <Header />
  <v-form v-model="valid" @submit.prevent="submitForm" style="margin: 4rem">
    <center><span class="text-h6">Cadastro de usuário</span></center>
    <v-container>
      <v-row>
        <v-col cols="12" md="4">
          <v-text-field
            v-model="firstname"
            :counter="10"
            :rules="nameRules"
            label="Nome completo"
            hide-details
            required
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="4">
          <v-text-field
            v-model="lastname"
            :counter="10"
            :rules="nameRules"
            label="Nome social"
            hide-details
            required
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="4">
          <v-text-field
            v-model="cpf"
            :rules="cpfRules"
            label="CPF"
            hide-details
            required
          ></v-text-field>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12" md="4">
          <v-text-field
            v-model="fathername"
            :counter="10"
            label="Nome do pai"
            hide-details
            required
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="4">
          <v-text-field
            v-model="mothername"
            :counter="10"
            label="Nome da mãe"
            hide-details
            required
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="4">
          <v-text-field
            v-model="phone"
            :rules="phoneRules"
            label="Telefone"
            hide-details
            required
          ></v-text-field>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12">
          <v-text-field
            v-model="email"
            :rules="emailRules"
            label="E-mail"
            hide-details
            required
          ></v-text-field>
        </v-col>
      </v-row>

      <v-row v-if="errorMessage" justify="center">
        <v-col cols="12" md="8">
          <v-alert
            v-model="showErrorAlert"
            dismissible
            border="left"
            color="error"
            icon="mdi-alert-circle-outline"
            transition="scale-transition"
          >
            <strong>Não foi possível completar a operação:</strong>
            <ul>
              <li v-for="(error, fieldName) in errorMessage" :key="fieldName">
                {{ error }}
              </li>
            </ul>
          </v-alert>
        </v-col>
      </v-row>

      <v-row v-if="successMessage" justify="center">
        <v-col cols="12" md="8">
          <v-alert
            v-model="showSuccessAlert"
            dismissible
            border="left"
            color="success"
            icon="mdi-check-circle-outline"
            transition="scale-transition"
          >
            {{ successMessage }}
          </v-alert>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12">
          <v-btn type="submit" color="primary">CADASTRAR</v-btn>
        </v-col>
      </v-row>
    </v-container>
  </v-form>
</template>

<script>
import axios from "axios";
import Header from "./../layouts/Header.vue";

export default {
  data() {
    return {
      valid: false,
      firstname: "",
      lastname: "",
      cpf: "",
      fathername: "",
      mothername: "",
      phone: "",
      email: "",
      nameRules: [
        (v) => !!v || "Campo obrigatório",
        (v) => (v && v.length <= 30) || "Máximo de 30 caracteres",
      ],
      cpfRules: [
        (v) => !!v || "Campo obrigatório",
        (v) =>
          (v && v.length === 11) || "CPF deve conter exatamente 11 caracteres",
      ],
      phoneRules: [
        (v) => !!v || "Campo obrigatório",
        (v) =>
          (v && v.length >= 8 && v.length <= 15) ||
          "Telefone deve conter entre 8 e 15 caracteres",
      ],
      emailRules: [
        (v) => !!v || "Campo obrigatório",
        (v) => /.+@.+\..+/.test(v) || "E-mail deve ser válido",
      ],
      errorMessage: null,
      successMessage: null,
      showErrorAlert: false,
      showSuccessAlert: false,
    };
  },
  methods: {
    submitForm() {
      axios
        .post("/api/user/store", {
          name: this.firstname,
          social_name: this.lastname,
          document: this.cpf,
          father_name: this.fathername,
          mother_name: this.mothername,
          contact: this.phone,
          email: this.email,
          password: this.cpf,
        })
        .then((response) => {
          console.log("Resposta recebida:", response);
          this.successMessage = "Cadastro realizado com sucesso!";
          this.showSuccessAlert = true;
          window.location.href = `/?usuario=${this.document}`;
        })
        .catch((error) => {
          console.error("Erro ao enviar dados:", error);
          if (error.response && error.response.data) {
            this.errorMessage = error.response.data.errors;
            this.showErrorAlert = true;
          }
        });
    },
    clearForm() {
      this.firstname = "";
      this.lastname = "";
      this.cpf = "";
      this.fathername = "";
      this.mothername = "";
      this.phone = "";
      this.email = "";
      this.valid = false;
    },
  },
  components: {
    Header,
  },
};
</script>
