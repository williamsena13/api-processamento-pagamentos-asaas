<template>
  <div>
    <div class="d-flex justify-content-center" v-if="loading">
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <div class="row justify-content-center" v-if="!loading">
      <div class="col-4" v-for="option in paymentOptions">
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
    localStorage.removeItem("paymentOption");
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
      localStorage.setItem("paymentOption", o.value);
    },
  },
};
</script>

<style>
.btn-pagamento {
  width: 100%;
  height: 100%;
}
</style>
