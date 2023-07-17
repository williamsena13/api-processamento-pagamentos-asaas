<template>
  <div class="row">
    <button
      type="button"
      class="d-none"
      ref="btnbuscarcep"
      @click="getCep()"
    ></button>
    <div class="col-md-3 col-sm-4 col-xs-12">
      <label>CEP</label>
      <div class="input-group gbox_cep">
        <input
          class="form-control cep"
          type="number"
          min="0"
          placeholder="00.000-000"
          v-model="cep"
          ref="inputCep"
        />
      </div>
    </div>
    <div class="col-md-6 col-sm-4 col-xs-12">
      <label>Endereço</label>
      <input
        class="form-control uppercase"
        type="text"
        maxlength="150"
        v-model="logradouro"
        ref="inputLogradouro"
      />
    </div>
    <div class="col-md-3 col-sm-4 col-xs-12">
      <label>Número</label>
      <input
        class="form-control"
        type="text"
        min="0"
        maxlength="5"
        max="99999"
        v-model="numero"
        ref="inputNumLogradouro"
      />
    </div>
    <div class="col-md-3 col-sm-4 col-xs-12">
      <label>Bairro</label>
      <input
        class="form-control uppercase"
        type="text"
        maxlength="100"
        v-model="bairro"
        ref="inputBairro"
      />
    </div>
    <div class="col-md-6 col-sm-4 col-xs-12">
      <label>Cidade</label>
      <input
        class="form-control"
        type="text"
        maxlength="35"
        v-model="cidade"
        ref="inputCidade"
      />
    </div>
    <div class="col-md-3 col-sm-4 col-xs-12">
      <label for="edit_estado">Estado</label>
      <input
        class="form-control"
        type="text"
        maxlength="2"
        v-model="uf"
        ref="inputUf"
      />
    </div>
  </div>
</template>
  
  <script>
export default {
  data() {
    return {
      cep: "",
      logradouro: "",
      numero: "",
      bairro: "",
      cidade: "",
      uf: "",
    };
  },
  props: {
    cepValue: {
      type: String,
      default: "",
    },
  },
  watch: {
    cep() {
      if (this.cep.length < 8) {
        return;
      }
      this.getCep();
    },
    cepValue() {
      this.cep = newCep;
    },
  },
  methods: {
    getCep() {
      if (this.cep.length < 8) {
        return;
      }
      axios
        .get("https://viacep.com.br/ws/" + this.cep + "/json/")
        .then((response) => {
          if (response.status === 200) {
            if (response.data.logradouro) {
              this.logradouro = response.data.logradouro;
            } else {
              this.logradouro = "";
            }
            if (response.data.bairro) {
              this.bairro = response.data.bairro;
            } else {
              this.bairro = "";
            }
            this.cidade = response.data.localidade;
            this.uf = response.data.uf;

            let objUser = JSON.parse(localStorage.getItem("authUser"));
            if (objUser) {
              localStorage.removeItem("authUser");
              this.logradouro = objUser.logradouro;
              this.numero = objUser.numero;
              this.bairro = objUser.bairro;
            }
          }
        })
        .catch((error) => {
          //alert("CEP não encontrado!");
          //this.clearFields();
          console.log(error);
        });
    },
    clearFields() {
      this.cep = "";
      this.logradouro = "";
      this.numero = "";
      this.bairro = "";
      this.cidade = "";
      this.uf = "";
    },
  },
};
</script>
  