<template>
  <div class="container">
    <div
      class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center"
      v-if="!loading"
    >
      <h2 class="display-5">Obrigado pela preferência</h2>
      <h3 class="display-6">
        Você escolheu a forma de pagamento: {{ cobranca.formaPagamento }}
      </h3>
      <p class="lead">
        Em breve, o seu produto
        <strong>{{ cobranca.description }}</strong> estará disponível. Para isso
        efetue o pagamento para acessa-lo
      </p>
      <div v-if="cobranca.billingType == 'PIX'">
        <img :src="cobranca.pixQrCode" alt="QRCode do PIX" />
      </div>
      <div v-if="cobranca.billingType == 'CREDIT_CARD'">
        <vc-form-credit-card></vc-form-credit-card>
      </div>

      <div v-if="cobranca.billingType == 'BOLETO'">
        <a target="_blank" :href="cobranca.bankSlipUrl">Baixar Boleto</a>
      </div>

      <div v-if="cobranca.billingType == 'UNDEFINED'">
        <vc-payment-options></vc-payment-options>
      </div>

      <p>{{ cobranca }}</p>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      loading: false,
      cobranca: Object,
    };
  },
  mounted() {
    this.getCobrancas();
    debugger;
    let teste = JSON.parse(localStorage.getItem("retornoCompra"));
    this.cobranca = teste.payment;
    console.log(teste);
  },
  watch: {
    getLoading() {
      return this.loading;
    },
  },
  methods: {
    getCobrancas() {
      this.loading = true;
      this.$http
        .get("payments")
        .then((response) => {
          console.log(response);
          this.loading = false;
          if (response.data) {
            debugger;
            let resposta = response.data;
            this.cobranca = response.data.data[1];
            console.log(this.cobranca);
          }
        })
        .catch((error) => {
          this.loading = false;
          console.log("ERROR");
          console.log(error);
        });
    },
  },
};
</script>

<style>
</style>