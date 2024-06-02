<template>
  <Header />
  <v-form v-model="valid" @submit.prevent="submitForm" style="margin: 4rem">
    <v-container>
      <span class="text-h6">Dados básicos</span>
      <br /><br />
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

      <br /><br />
      <span class="text-h6 mt-12">Dados de endereço residencial</span>
      <br /><br />
      <v-row>
        <v-col cols="12" md="4">
          <v-text-field
            v-model="postalCodeResidence"
            label="CEP"
            required
            @blur="fetchAddressDataResidence"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="4">
          <v-text-field
            v-model="addressResidence"
            label="Logradouro"
            hide-details
            required
            :disabled="isAddressDisabled"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="4">
          <v-text-field
            v-model="numberResidence"
            label="Número"
            hide-details
            required
          ></v-text-field>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12" md="4">
          <v-text-field
            v-model="complementResidence"
            label="Complemento"
            hide-details
            required
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="4">
          <v-text-field
            v-model="neighborhoodResidence"
            label="Bairro"
            hide-details
            required
            :disabled="isNeighborhoodDisabled"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="4">
          <v-text-field
            v-model="ufResidence"
            label="Estado"
            hide-details
            required
            :disabled="isUfDisabled"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12" md="4">
          <v-text-field
            v-model="cityResidence"
            label="Cidade"
            hide-details
            required
            :disabled="isCityDisabled"
          ></v-text-field>
        </v-col>
      </v-row>

<br /><br />
      <span class="text-h6 mt-12">Dados de endereço comercial</span>
      <br /><br />
      <v-row>
        <v-col cols="12" md="4">
          <v-text-field
            v-model="postalCodeComercial"
            label="CEP"
            required
            @blur="fetchAddressDataComercial"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="4">
          <v-text-field
            v-model="addressComercial"
            label="Logradouro"
            hide-details
            required
            :disabled="isAddressDisabledComercial"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="4">
          <v-text-field
            v-model="numberComercial"
            label="Número"
            hide-details
            required
          ></v-text-field>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12" md="4">
          <v-text-field
            v-model="complementComercial"
            label="Complemento"
            hide-details
            required
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="4">
          <v-text-field
            v-model="neighborhoodComercial"
            label="Bairro"
            hide-details
            required
            :disabled="isNeighborhoodDisabledComercial"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="4">
          <v-text-field
            v-model="ufComercial"
            label="Estado"
            hide-details
            required
            :disabled="isUfDisabledComercial"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12" md="4">
          <v-text-field
            v-model="cityComercial"
            label="Cidade"
            hide-details
            required
            :disabled="isCityDisabledComercial"
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
            <strong>Ocorreram erros ao processar o formulário:</strong>
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
  props: {
    user: Object,
  },
  data() {
    return {
      valid: false,
      firstname: this.user.name,
      lastname: this.user.social_name,
      cpf: this.user.document,
      fathername: this.user.father_name,
      mothername: this.user.mother_name,
      phone: this.user.contact,
      email: this.user.email,
      isAddressDisabled: false,
      isNeighborhoodDisabled: false,
      isUfDisabled: false,
      isCityDisabled: false,
      isAddressDisabledComercial: false,
      isNeighborhoodDisabledComercial: false,
      isUfDisabledComercial: false,
      isCityDisabledComercial: false,
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
    fetchAddressDataResidence() {
      let cep = this.postalCodeResidence;
      if (cep.length === 8) {
        axios
          .get(`https://viacep.com.br/ws/${cep}/json/`)
          .then((response) => {
            const data = response.data;
            if (!data.erro) {
              this.addressResidence = data.logradouro;
              this.neighborhoodResidence = data.bairro;
              this.ufResidence = data.uf;
              this.cityResidence = data.localidade;

              // Bloquear os campos preenchidos automaticamente
              this.isAddressDisabled = true;
              this.isNeighborhoodDisabled = true;
              this.isUfDisabled = true;
              this.isCityDisabled = true;
            } else {
              console.error("CEP não encontrado");
              this.clearAddressFields();
            }
          })
          .catch((error) => {
            console.error("Erro ao buscar dados do CEP:", error);
            this.clearAddressFields();
          });
      } else {
        console.error("CEP inválido");
        this.clearAddressFields();
      }
    },
    fetchAddressDataComercial() {
      const cep = this.postalCodeComercial;
      if (cep.length === 8) {
        axios
          .get(`https://viacep.com.br/ws/${cep}/json/`)
          .then((response) => {
            const data = response.data;
            if (!data.erro) {
              this.addressComercial = data.logradouro;
              this.neighborhoodComercial = data.bairro;
              this.ufComercial = data.uf;
              this.cityComercial = data.localidade;

              // Bloquear os campos preenchidos automaticamente
              this.isAddressDisabledComercial = true;
              this.isNeighborhoodDisabledComercial = true;
              this.isUfDisabledComercial = true;
              this.isCityDisabledComercial = true;
            } else {
              console.error("CEP não encontrado");
              this.clearAddressFieldsComercial();
            }
          })
          .catch((error) => {
            console.error("Erro ao buscar dados do CEP:", error);
            this.clearAddressFieldsComercial();
          });
      } else {
        console.error("CEP inválido");
        this.clearAddressFieldsComercial();
      }
    },
    clearAddressFields() {
      this.addressResidence = "";
      this.neighborhoodResidence = "";
      this.ufResidence = "";
      this.cityResidence = "";

      this.isAddressDisabled = false;
      this.isNeighborhoodDisabled = false;
      this.isUfDisabled = false;
      this.isCityDisabled = false;
    },
    clearAddressFieldsComercial() {
      this.addressComercial = "";
      this.neighborhoodComercial = "";
      this.ufComercial = "";
      this.cityComercial = "";

      this.isAddressDisabledComercial = false;
      this.isNeighborhoodDisabledComercial = false;
      this.isUfDisabledComercial = false;
      this.isCityDisabledComercial = false;
    },
    clearForm() {
      this.firstname = "";
      this.lastname = "";
      this.cpf = "";
      this.fathername = "";
      this.mothername = "";
      this.phone = "";
      this.email = "";
      this.postalCodeResidence = "";
      this.addressResidence = "";
      this.numberResidence = "";
      this.complementResidence = "";
      this.neighborhoodResidence = "";
      this.ufResidence = "";
      this.cityResidence = "";
      this.valid = false;

      this.clearAddressFields();
    },
  },
  components: {
    Header,
  },
};
</script>
