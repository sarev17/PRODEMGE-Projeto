
<template>
  <div>
    <v-toolbar>
      <v-app-bar-nav-icon></v-app-bar-nav-icon>

      <v-toolbar-title>
        <img src="/images/logo_prodemge.png" alt=""
      /></v-toolbar-title>

      <v-spacer></v-spacer>

      <v-btn icon>
        <v-icon>mdi-export</v-icon>
      </v-btn>
    </v-toolbar>
  </div>
  <div style="margin: 3rem">
    <v-sheet class="mx-auto" width="300">
      <v-form @submit.prevent="submitForm">
        <center><span class="text-h6">Gerenciamento de usuários</span></center>
        <v-text-field
        class="mt-8"
          v-model="inputSearch"
          :rules="rules"
          label="Busca por nome, CPF ou ID"
        ></v-text-field>
        <v-btn class="mt-2" type="submit" block>Buscar</v-btn>
        <v-btn style="background-color: #00796B;color:white" class="mt-3 teal-lighten-3" type="submit" block>+ Cadastrar</v-btn>
      </v-form>
    </v-sheet>

    <v-data-table
      class="mt-12"
      v-if="dataLoaded"
      v-model:page="page"
      :headers="headers"
      :items="desserts"
      :items-per-page="itemsPerPage"
    >
      <template v-slot:bottom>
        <div class="text-center pt-2">
          <v-pagination v-model="page" :length="pageCount"></v-pagination>
        </div>
      </template>
    </v-data-table>
  </div>
</template>

<script>
import axios from "axios";
import backgroundImage from "@/assets/images/logo_prodemge.png";

export default {
  data() {
    return {
      backgroundImage,
      inputSearch: "",
      rules: [
        (value) => {
          if (value) return true;
          return "Preencha esse campo";
        },
      ],
      desserts: [],
      headers: [
        { title: "ID", key: "id" },
        { title: "Usuário", key: "name" },
        { title: "Documento", key: "document" },
        { title: "Data de cadastro", key: "register" },
      ],
      page: 1,
      itemsPerPage: 5,
      pageCount: 0,
      dataLoaded: false,
    };
  },
  methods: {
    submitForm() {
      axios
        .get(`/api/search/${this.inputSearch}`)
        .then((response) => {
          console.log("sucesso", response.data);
          this.desserts = response.data.response;
          this.dataLoaded = true;
        })
        .catch((error) => {
          console.log("error", error);
          this.desserts = [];
          this.dataLoaded = true;
        });
    },
  },
};
</script>
