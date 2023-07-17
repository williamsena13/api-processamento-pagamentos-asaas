<template>
  <div class="credit-card-form">
    <div class="credit-card-preview col-4">
      <div class="card-holder">{{ cardHolder }}</div>
      <div class="card-number">{{ maskedCardNumber }}</div>
      <div class="card-expiry">{{ formattedExpiry }}</div>
    </div>
    <form class="credit-card-inputs col-4">
      <div class="row">
        <input
          class="col-12"
          type="text"
          v-model="cardHolder"
          placeholder="Titular do cartão"
        />
        <input
          class="col-8"
          type="number"
          v-model="cardNumber"
          placeholder="Número do cartão"
        />
        <input class="col-4" type="number" v-model="cvc" placeholder="CVC" />
        <input
          class="col-5"
          type="number"
          v-model="expiryMonth"
          placeholder="Mês de validade"
        />
        <input
          class="col-7"
          type="number"
          v-model="expiryYear"
          placeholder="Ano de validade"
        />
      </div>
      <div style="text-align: center">
        <button
          type="button"
          class="btn btn-outline-success btn-block"
          @click="finalizarCompra()"
        >
          Finalizar Compra
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import swal from "sweetalert";
export default {
  data() {
    return {
      cardNumber: "",
      cardHolder: "",
      expiryMonth: "",
      expiryYear: "",
      cvc: "",
    };
  },
  watch: {
    cardNumber() {
      if (this.cardNumber.length > 16) {
        this.cardNumber = this.cardNumber.slice(0, 16);
      }
    },
    expiryMonth() {
      if (this.expiryMonth.length > 2) {
        this.expiryMonth = this.expiryMonth.slice(0, 2);
      }
      if (this.expiryMonth > 12) {
        this.expiryMonth = "";
      }
    },
    expiryYear() {
      if (this.expiryYear.length > 4) {
        this.expiryYear = this.expiryYear.slice(0, 3);
      }
      let ano = new Date().getFullYear();
      if (this.expiryYear.length == 4) {
        if (Number(ano) > Number(this.expiryYear)) {
          this.expiryYear = "";
        }
      }
    },
    cvc() {
      if (this.cvc.length > 3) {
        this.cvc = this.cvc.slice(0, 3);
      }
    },
  },
  computed: {
    maskedCardNumber() {
      const last4Digits = this.cardNumber.slice(-4);
      return `**** **** **** ${last4Digits}`;
    },
    formattedExpiry() {
      return `${this.expiryMonth}/${this.expiryYear.slice(-2)}`;
    },
  },
  methods: {
    finalizarCompra() {
      let parametro = {
        paymentId: localStorage.getItem("paymentId"),
        cardNumber: this.cardNumber,
        cardHolder: this.cardHolder,
        expiryMonth: this.expiryMonth,
        expiryYear: this.expiryYear,
        cvc: this.cvc,
      };
      this.$http
        .post("/paycharge", parametro)
        .then((response) => {
          console.log("Sucesso");
          console.log(response);
          if (response.response) {
            let resposta = response.response;
            debugger;
            if (resposta.status == 500) {
              try {
                console.log(resposta.data);
                let teste = JSON.parse(resposta.data.msg);
                console.log(teste);
              } catch (error) {}
              swal(resposta.data.msg, "", "error");
            }
            if (resposta.status == 400) {
              swal(resposta.data, "", "warning");
            }
            return;
          }
          if (response.data) {
            let resposta = response.data;
            if (resposta.status == "error") {
              swal("Erro ao pagar", resposta.msg, resposta.status);
              return;
            }
            console.log(response.data);
          }
        })
        .catch((error) => {
          console.log("error");
          console.log(error);
        });
    },
  },
};
</script>

<style scoped>
.credit-card-form {
  display: flex;
  align-items: center;
  gap: 20px;
}

.credit-card-preview {
  width: 200px;
  height: 120px;
  background-color: #f0f0f0;
  border-radius: 6px;
  padding: 10px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.card-number {
  font-size: 16px;
  font-weight: bold;
}

.credit-card-inputs {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

input {
  padding: 8px;
  border-radius: 4px;
  border: 1px solid #ccc;
}
</style>
