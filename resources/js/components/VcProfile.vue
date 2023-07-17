<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <h2 class="card-header">Perfil</h2>

          <div class="card-body">
            <div class="row">
              <div class="form-group col-4">
                <label for="cnpj">CNPJ/CPF:</label>
                <input
                  type="text"
                  id="cnpj"
                  class="form-control"
                  v-model="user.cnpj"
                  @input="validateField('cnpj')"
                  :class="{ 'is-invalid': errors.cnpj }"
                />
                <div class="invalid-feedback" v-if="errors.cnpj">
                  {{ errors.cnpj[0] }}
                </div>
              </div>

              <div class="form-group col-8">
                <label for="name">Nome:</label>
                <input
                  type="text"
                  id="name"
                  class="form-control"
                  v-model="user.name"
                  @input="validateField('name')"
                  :class="{ 'is-invalid': errors.name }"
                />
                <div class="invalid-feedback" v-if="errors.name">
                  {{ errors.name[0] }}
                </div>
              </div>

              <div class="form-group col-4">
                <label for="mobilePhone">Celular:</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="user.mobilePhone"
                />
                <div class="invalid-feedback" v-if="errors.mobilePhone">
                  {{ errors.mobilePhone[0] }}
                </div>
              </div>

              <div class="form-group col-8">
                <label for="email">E-mail:</label>
                <input
                  type="email"
                  id="email"
                  class="form-control"
                  v-model="user.email"
                  @input="validateField('email')"
                  :class="{ 'is-invalid': errors.email }"
                  readonly
                />
                <div class="invalid-feedback" v-if="errors.email">
                  {{ errors.email[0] }}
                </div>
              </div>
            </div>

            <vc-div-cep ref="cepComponent"></vc-div-cep>
          </div>
          <div class="card-footer text-right">
            <button
              type="submit"
              class="btn btn-primary"
              :disabled="loading"
              @click="submitForm()"
            >
              Salvar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {
        name: "",
        email: "",
        cnpj: "",
        mobilePhone: "",
      },
      errors: {},
      loading: false,
    };
  },
  comments: {},
  methods: {
    validateField(field) {
      // Lógica de validação para cada campo
      switch (field) {
        case "name":
          if (!this.user.name) {
            this.errors.name = ["O campo nome é obrigatório."];
          } else {
            this.errors.name = [];
          }
          break;
        case "email":
          if (!this.user.email) {
            this.errors.email = ["O campo e-mail é obrigatório."];
          } else {
            // Validar formato de e-mail utilizando uma expressão regular
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(this.user.email)) {
              this.errors.email = ["O e-mail informado é inválido."];
            } else {
              this.errors.email = [];
            }
          }
          break;
        case "cnpj":
          // Lógica de validação para o campo CNPJ/CPF
          // ...
          break;
        case "mobilePhone":
          // Lógica de validação para o campo de telefone
          // ...
          break;
        default:
          break;
      }
    },
    submitForm() {
      // Validar todos os campos antes de enviar o formulário
      this.validateField("name");
      this.validateField("email");
      this.validateField("cnpj");
      this.validateField("mobilePhone");

      if (
        Object.keys(this.errors).some((field) => this.errors[field].length > 0)
      ) {
        return;
      }

      this.loading = true;
      const cepComponent = this.$refs.cepComponent;
      debugger;
      this.user.postalCode = cepComponent.cep;
      this.user.address = cepComponent.logradouro;
      this.user.addressNumber = cepComponent.numero;
      this.user.province = cepComponent.bairro;
      this.user.state = cepComponent.uf;

      this.$http
        .post("/profile", this.user)
        .then((response) => {
          this.loading = false;
        })
        .catch((error) => {
          this.loading = false;
        });
    },
    getUser() {
      this.$http
        .get("/auth")
        .then((response) => {
          this.user = response.data;
          const cepComponent = this.$refs.cepComponent; // Acessando o componente VcDivCep através do ref
          try {
            cepComponent.cep = this.user.cep;
            localStorage.setItem("authUser", JSON.stringify(response.data));
          } catch (error) {
            console.log(error);
          }
        })
        .catch((error) => {
          console.log("error");
          console.log(error);
        });
    },
  },
  mounted() {
    this.getUser();
  },
};
</script>

<style>
.is-invalid {
  border-color: #dc3545;
}
.invalid-feedback {
  color: #dc3545;
  margin-top: 0.25rem;
  font-size: 80%;
}
</style>
