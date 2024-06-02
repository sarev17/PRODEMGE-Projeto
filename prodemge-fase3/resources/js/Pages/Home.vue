<template>
  <div>
    <Header />
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
        <v-btn
          @click="register"
          style="background-color: #00796b; color: white"
          class="mt-3 teal-lighten-3"
          type="button"
          block
          >+ Cadastrar</v-btn
        >
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
      <template v-slot:item.actions="{ item }">
        <div class="d-flex">
          <v-col cols="auto" style="display:flex;column-gap:0.5rem">
            <v-btn icon="mdi-open-in-new" size="small" style="color:white;background-color:#00008d"></v-btn>
            <v-btn icon="mdi-eye" size="small" style="color:white;background-color:#00796B"></v-btn>
          </v-col>
        </div>
      </template>

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
import Header from "./../layouts/Header.vue";

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
        { title: "Ações", key: "actions" },
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
    register() {
      window.location.href = "/usuario/cadastro";
    },
    viewItem(item) {
      console.log("Visualizar item:", item);
    },
    editItem(item) {
      console.log("Editar item:", item);
    },
  },
  components: {
    Header,
  },
};
</script>
