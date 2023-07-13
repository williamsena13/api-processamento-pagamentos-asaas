<template>
  <div>
    <div class="d-flex justify-content-center" v-if="loading">
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <div class="row justify-content-center" v-if="!loading">
      <div class="col-3" v-for="option in paymentOptions">
        <button
          type="button"
          :class="
            paymentOption == option.id
              ? 'btn btn-outline-success btn-pagamento'
              : 'btn btn-outline-dark btn-pagamento'
          "
          :key="option.id"
          @click="setOption(option)"
        >
          {{ option.description }}
        </button>
      </div>
    </div>

    <hr />

    <div class="row" v-if="!loading">
      <div class="col-6">
        <div class="container p-0">
          <h5 class="h8 py-3">Dados do Cartão</h5>
          <div class="row gx-3">
            <div class="col-12">
              <div class="d-flex flex-column">
                <p class="text mb-1">Nº do Cartão</p>
                <input
                  class="form-control mb-3"
                  type="text"
                  placeholder="1234 5678 435678"
                />
              </div>
            </div>
            <div class="col-6">
              <div class="d-flex flex-column">
                <p class="text mb-1">Vencimento</p>
                <input
                  class="form-control mb-3"
                  type="text"
                  placeholder="MM/YYYY"
                />
              </div>
            </div>
            <div class="col-6">
              <div class="d-flex flex-column">
                <p class="text mb-1">CVV/CVC</p>
                <input
                  class="form-control mb-3 pt-2"
                  type="password"
                  placeholder="***"
                />
              </div>
            </div>
            <div class="col-12">
              <button class="btn btn-block btn-primary">Salvar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="card" v-if="!loading"></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      paymentOptions: null,
      paymentOption: null,
      loading: false,
    };
  },
  mounted() {
    console.log("Component mounted.");
    this.findPaymentOptions();
  },
  watch: {
    getLoading() {
      return this.loading;
    },
  },
  methods: {
    findPaymentOptions() {
      this.loading = true;
      this.$http
        .get("paymentOptions")
        .then((response) => {
          this.loading = false;
          console.log("Sucesso ao buscar opções");
          console.log(response);

          if (response.data) {
            this.paymentOptions = response.data;
          }
        })
        .catch((error) => {
          this.loading = false;
          console.log(error);
        });
    },
    setOption(o) {
      console.log("Selecionando");
      console.log(o);
      this.paymentOption = o.id;
    },
  },
};
</script>

<style>
.btn-pagamento {
  width: 100%;
  height: 60px;
}
</style>
