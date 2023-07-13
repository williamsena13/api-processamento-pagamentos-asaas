<template>
  <div class="credit-card-form">
    <div class="credit-card-preview">
      <div class="card-number">{{ maskedCardNumber }}</div>
      <div class="card-holder">{{ cardHolder }}</div>
      <div class="card-expiry">{{ formattedExpiry }}</div>
    </div>
    <form class="credit-card-inputs">
      <input type="text" v-model="cardNumber" placeholder="Número do cartão" />
      <input type="text" v-model="cardHolder" placeholder="Titular do cartão" />
      <input type="text" v-model="expiryMonth" placeholder="Mês de validade" />
      <input type="text" v-model="expiryYear" placeholder="Ano de validade" />
      <input type="text" v-model="cvc" placeholder="CVC" />
    </form>
  </div>
</template>
  
  <script>
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
  computed: {
    maskedCardNumber() {
      // Função para exibir apenas os 4 últimos dígitos do cartão
      const last4Digits = this.cardNumber.slice(-4);
      return `**** **** **** ${last4Digits}`;
    },
    formattedExpiry() {
      // Função para exibir a data de validade formatada (MM/AA)
      return `${this.expiryMonth}/${this.expiryYear.slice(-2)}`;
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
  