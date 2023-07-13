<template>
  <div class="container">
    <div
      class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center"
      v-if="!loading"
    >
      <h1 class="display-5">Obrigado pela preferência</h1>
      <p class="lead">
        Nós agradecemos a preferência! Em breve, o seu produto
        <strong>{{ cobranca.description }}</strong> estará disponível.
      </p>

      <template v-switch="cobranca.billingType">
        <template case="'PIX'">
          <div>
            <!-- Mostrar o QRCode para pagamento via PIX -->
            <img :src="cobranca.pixQrCode" alt="QRCode do PIX" />
          </div>
        </template>
        <template case="'CREDIT_CARD'">
          <div>
            <!-- Mostrar o formulário para preencher os dados do cartão de crédito -->
            <vc-form-credit-card></vc-form-credit-card>
          </div>
        </template>
        <template case="'BOLETO'">
          <div>
            <!-- Link com botão que direciona para o download do boleto -->
            <a target="_blank" :href="cobranca.bankSlipUrl">Baixar Boleto</a>
          </div>
        </template>
        <template case="'UNDEFINED'">
          <div>
            <!-- Carregar componente Vue <vc-payment-options></vc-payment-options> -->
            <vc-payment-options></vc-payment-options>
          </div>
        </template>
        <template default>
          <div>
            <h1>Não tem</h1>
          </div>
        </template>
      </template>
    </div>
    <div v-if="loading">
      <h1>Não achei</h1>
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
            this.cobranca = response.data.data[0];
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