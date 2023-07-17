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
        efetue o pagamento.
      </p>
      <div v-if="cobranca.billingType == 'PIX'">
        <!--<img :src="cobranca.pixQrCode" alt="QRCode do PIX" />-->
        <div v-if="showQrCode">
          <pix-qrcode :codigo-qr="cobranca.codigoQR"></pix-qrcode>
        </div>
      </div>
      <div v-if="cobranca.billingType == 'CREDIT_CARD'" class="container">
        <p class="lead">
          Continue sua compra aqui,
          <a target="_blank" :href="cobranca.invoiceUrl">clique aqui</a>
        </p>
        <vc-form-credit-card></vc-form-credit-card>
      </div>

      <div v-if="cobranca.billingType == 'BOLETO'">
        <p class="lead">
          Para acessa-lo seu Boleto,
          <a target="_blank" :href="cobranca.bankSlipUrl">clique aqui</a>
        </p>
      </div>
      <!--
      <div v-if="cobranca.billingType == 'UNDEFINED'">
        <vc-payment-options></vc-payment-options>
      </div>
      -->
    </div>
  </div>
</template>


<script>
import PixQRCode from "./PixQRCode.vue";

export default {
  components: {
    PixQRCode,
  },
  data() {
    return {
      loading: false,
      cobranca: Object,
      showQrCode: false,
    };
  },
  mounted() {
    //this.getCobrancas();
    let retorno = JSON.parse(localStorage.getItem("retornoCompra"));
    this.cobranca = retorno.payment;
    localStorage.setItem("paymentId", this.cobranca.id);
    console.log(retorno.payment);
    if (this.cobranca.billingType == "PIX") {
      setTimeout(() => {
        this.showQrCode = true;
        localStorage.setItem("qrCode", JSON.stringify(this.cobranca.codigoQR));
        console.log(this.cobranca.codigoQR);
      }, 1000);
    }
  },
  watch: {
    getLoading() {
      return this.loading;
    },
  },
  methods: {},
};
</script>

<style>
</style>