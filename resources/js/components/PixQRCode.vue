<template>
  <div>
    <div v-if="success">
      <qrcode :value="codigoQR"></qrcode>
    </div>
    <div v-else>Ocorreu um erro ao carregar o QR Code.</div>
  </div>
</template>
  
  <script>
import QRCode from "qrcode";

export default {
  props: {
    codigoQR: {
      type: Object,
    },
  },
  data() {
    return {
      success: true,
    };
  },
  mounted() {
    this.generateQRCode();
  },
  methods: {
    generateQRCode() {
      debugger;
      let qrCode = JSON.parse(localStorage.getItem("qrCode"));
      const { encodedImage, expirationDate, payload } = qrCode; //this.codigoQR;

      const canvas = document.createElement("canvas");
      QRCode.toCanvas(canvas, payload, (error) => {
        if (error) {
          this.success = false;
        } else {
          this.$el.querySelector("qrcode").appendChild(canvas);
        }
      });
    },
  },
};
</script>
  
  <style scoped>
/* Estilos opcionais para o componente */
</style>
  