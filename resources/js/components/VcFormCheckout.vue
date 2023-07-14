<template>
  <div class="container">
    <div class="py-3 text-center">
      <h2>Finalize sua compra</h2>
    </div>

    <div class="row">
      <div class="col-md-8 order-md-1">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <label>Nome Completo</label>
                <input
                  type="text"
                  class="form-control"
                  :value="name"
                  readonly
                />
              </div>
              <div class="col-12">
                <label>Email</label>
                <input
                  type="email"
                  class="form-control"
                  ref="emailInput"
                  v-model="email"
                  @change="validateEmail()"
                  required
                />
                <div class="invalid-feedback">
                  Favor inserir um e-mail válido
                </div>
              </div>
              <div class="col-6">
                <label>CPF/CNPJ</label>
                <input
                  type="text"
                  class="form-control"
                  ref="cnpjInput"
                  v-model="cnpj"
                  required
                />
                <div class="invalid-feedback">
                  Favor inserir um CPF/CNPJ válido
                </div>
              </div>
              <div class="col-6">
                <label>Celular</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <select class="custom-select">
                      <option selected>+55</option>
                    </select>
                  </div>
                  <input
                    type="tel"
                    class="form-control"
                    ref="mobilePhoneInput"
                    placeholder="(00) 0000-0000"
                    v-model="mobilePhone"
                    @change="validateMobilePhone()"
                  />
                  <div class="invalid-feedback">
                    Favor inserir um Celular Válido
                  </div>
                </div>
              </div>
              <div class="col-12">
                <label>Descrição</label>
                <input
                  type="text"
                  class="form-control"
                  ref="descriptionInput"
                  v-model="description"
                  required
                  @change="validDescription()"
                />
                <div class="invalid-feedback">
                  Favor inserir uma descrição válida
                </div>
              </div>
              <div class="col-12">
                <label>Vencimento</label>
                <input
                  type="date"
                  class="form-control"
                  ref="dueDateInput"
                  v-model="dueDate"
                  required
                  @change="validateDueDate()"
                />
                <div class="invalid-feedback">
                  Favor inserir uma descrição válida
                </div>
              </div>
            </div>

            <h4 class="mb-3" style="padding-top: 20px">Forma de Pagamento</h4>
            <div
              class="alert alert-danger"
              role="alert"
              ref="alertPaymentOptions"
              v-if="!paymentOption"
            >
              Favor selecionar uma Forma de Pagamento
            </div>
            <vc-payment-options
              v-model="paymentOption"
              @click="validPaymentOption()"
            ></vc-payment-options>
          </div>
        </div>
      </div>
      <div class="col-md-4 order-md-2 mb-4">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-muted">Sua Cobrança</span>
          <span class="badge badge-secondary badge-pill">3</span>
        </h4>
        <ul class="list-group mb-3">
          <li
            class="list-group-item d-flex justify-content-between lh-condensed"
          >
            <div>
              <h6 class="my-0">Produto<a href=""></a></h6>
              <small class="text-muted">Exemplo de descrição</small>
            </div>
            <span class="text-muted">R$10</span>
          </li>

          <li class="list-group-item d-flex justify-content-between">
            <span>Total (R$)</span>
            <strong>R$<span id="span-value">20,00</span></strong>
          </li>
        </ul>
      </div>
    </div>

    <div class="row" style="padding-top: 20px">
      <div class="col-md-8 justify-center align-items-center">
        <button
          class="btn btn-primary btn-lg btn-block"
          @click="finalizarVenda"
          id="btn-finalizar"
        >
          Finalizar
        </button>
      </div>
    </div>
    <div class="row" style="padding-top: 20px">
      <div class="col-md-8 justify-center align-items-center">
        <router-link class="btn btn-primary btn-lg btn-block" to="/obrigado">
          TESTE
        </router-link>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {},
  data() {
    return {
      name: "",
      email: "",
      cnpj: "",
      mobilePhone: "",
      dueDate: "",
      valid: false,
      description: "",
      paymentOption: null,
      user: Object,
    };
  },
  methods: {
    finalizarVenda() {
      this.validateEmail();
      this.validarDocumento();
      this.validateMobilePhone();
      this.validDescription();
      this.validPaymentOption();

      this.valid = true;
      if (!this.paymentOption) {
        return;
      }
      let parametro = {
        billingType: this.paymentOption,
        value: document.getElementById("span-value").innerText,
        name: this.name,
        email: this.email,
        cnpj: this.cnpj,
        dueDate: this.dueDate,
        mobilePhone: this.mobilePhone,
        description: this.description,
      };
      try {
        this.$http
          .post("/payments", parametro)
          .then((response) => {
            console.log("AQUI");

            console.log("Sucesso ao gravar pagamento");
            console.log(response);
            if (response.response) {
              console.log(response.response);
              let resposta = response.response.data;
              console.log(response.response.data);
              if (resposta.msg) {
                alert(resposta.msg);
                return;
              }
              if (resposta.errorMessage) {
                console.log(resposta.errorMessage);
              }
              console.log();
              if (resposta.status == 500) {
              }
            }

            if (response.status) {
              console.log(response.status);
            }

            if (response.data) {
              let resposta = response.data;
              console.log(resposta);
              localStorage.setItem("retornoCompra", JSON.stringify(resposta));
              this.$router.push({
                name: "thanks",
              });
            }
          })
          .catch((error) => {
            this.loading = false;
            console.log(error);
          });
      } catch (error) {
        console.log("ERRO AO MANDAR ARQUIVO");
        console.log(error);
      }
    },
    populeUser() {
      this.name = this.user.name;
      this.email = this.user.email ?? "";
      this.cnpj = this.user.cnpj ?? "";
      this.mobilePhone = this.user.mobile_phone ?? "";
    },

    validarDocumento() {
      let documento = this.cnpj;
      const cleanDocumento = documento.replace(/\D/g, "");
      let bValido = false;
      if (cleanDocumento.length === 11) {
        bValido = this.validarCPF(cleanDocumento);
      } else if (cleanDocumento.length === 14) {
        bValido = this.validarCNPJ(cleanDocumento);
      }

      if (this.cnpj.length === 0 || !bValido) {
        this.$refs.cnpjInput.classList.add("is-invalid");
        this.valid = false;
        return;
      } else {
        if (this.$refs.cnpjInput) {
          this.$refs.cnpjInput.classList.remove("is-invalid");
          this.valid = false;
        }
        return;
      }
    },
    validarCPF(cpf) {
      // Validação do CPF
      const cpfNumbers = cpf.split("").map(Number);
      const [digito1, digito2] = cpfNumbers.slice(9);

      // Verifica o primeiro dígito verificador
      let soma = cpfNumbers.slice(0, 9).reduce((acc, value, index) => {
        return acc + value * (10 - index);
      }, 0);
      let resto = (soma * 10) % 11;
      if (resto === 10 || resto === digito1) {
        soma = cpfNumbers.slice(0, 10).reduce((acc, value, index) => {
          return acc + value * (11 - index);
        }, 0);
        resto = (soma * 10) % 11;
        if (resto === 10 || resto === digito2) {
          return true;
        }
      }

      return false;
    },
    validarCNPJ(cnpj) {
      // Validação do CNPJ
      const cnpjNumbers = cnpj.split("").map(Number);
      const [digito1, digito2] = cnpjNumbers.slice(12);

      // Verifica o primeiro dígito verificador
      let soma = cnpjNumbers.slice(0, 12).reduce((acc, value, index) => {
        const peso = index < 4 ? 5 - index : 13 - index;
        return acc + value * peso;
      }, 0);
      let resto = soma % 11;
      if (resto < 2 ? digito1 === 0 : digito1 === 11 - resto) {
        soma = cnpjNumbers.slice(0, 13).reduce((acc, value, index) => {
          const peso = index < 5 ? 6 - index : 14 - index;
          return acc + value * peso;
        }, 0);
        resto = soma % 11;
        if (resto < 2 ? digito2 === 0 : digito2 === 11 - resto) {
          return true;
        }
      }

      return false;
    },
    validateEmail() {
      // Regex para validação de e-mail]
      let email = this.email;
      const emailRegex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
      //return emailRegex.test(email);
      if (this.email.length === 0 || !emailRegex.test(email)) {
        this.$refs.emailInput.classList.add("is-invalid");
        this.valid = false;
        return;
      } else {
        this.$refs.emailInput.classList.remove("is-invalid");
      }
    },
    validateMobilePhone() {
      let mobilePhone = this.mobilePhone;
      // Regex para validação de celular
      const mobilePhoneRegex = /^\(\d{2}\) \d{4,5}-\d{4}$/;
      //return mobilePhoneRegex.test(mobilePhone);
      if (
        this.mobilePhone.length === 0 ||
        !mobilePhoneRegex.test(mobilePhone)
      ) {
        this.$refs.mobilePhoneInput.classList.add("is-invalid");
        this.valid = false;
        return;
      } else {
        this.$refs.mobilePhoneInput.classList.remove("is-invalid");
      }
    },
    validDescription() {
      if (this.description.length === 0) {
        this.$refs.descriptionInput.classList.add("is-invalid");
        this.valid = false;
        return;
      } else {
        this.$refs.descriptionInput.classList.remove("is-invalid");
      }
    },
    validPaymentOption() {
      console.log("clickei");
      this.paymentOption = localStorage.getItem("paymentOption");
      if (!this.paymentOption) {
        this.$refs.alertPaymentOptions.classList.remove("d-none");
        document.getElementById("btn-finalizar").disabled = true;
        this.valid = true;
        return;
      } else {
        this.valid = false;
        if (this.$refs.alertPaymentOptions) {
          this.$refs.alertPaymentOptions.classList.add("d-none");
          document.getElementById("btn-finalizar").disabled = false;
        }
      }
    },
    validateDueDate() {
      const selectedDate = new Date(this.dueDate);
      const currentDate = new Date();

      if (selectedDate > currentDate) {
        this.$refs.dueDateInput.classList.remove("is-invalid");
      } else {
        this.$refs.dueDateInput.classList.add("is-invalid");
      }
    },
    getUser() {
      this.$http
        .get("/auth")
        .then((response) => {
          this.loading = false;

          if (response.response) {
            console.log("Deu ruimn");
            console.log(response.response);
          }
          localStorage.setItem("authUser", JSON.stringify(response.data));
          this.user = response.data;
          this.populeUser();
        })
        .catch((error) => {
          this.loading = false;
          console.log(error);
        });
    },
  },
  watch: {
    description() {
      console.log("ESTOU MUDANDO DESCRIT");
    },
    paymentOption() {
      console.log("MUDEI");
    },
  },
  mounted() {
    //this.populeUser();
    this.getUser();
    let currentDate = new Date();
    currentDate.setDate(currentDate.getDate() + 5);
    this.description = "Compra de Produto " + new Date().toLocaleString();
    this.dueDate = currentDate.toISOString().split("T")[0];
    this.$refs.dueDateInput.focus();
    setTimeout(() => {
      $(".btn-pagamento").on("click", () => {
        this.validPaymentOption();
      });
    }, 1000);
    this.$refs.alertPaymentOptions.classList.add("d-none");
  },
};
</script>