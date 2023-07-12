<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Bem-vindo</div>

          <div class="card-body"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
    };
  },
  mounted() {},
  watch: {
    getLoading() {
      return this.loading;
    },
  },
  methods: {
    setOption(o) {
      console.log("Selecionando");
      console.log(o);
      this.paymentOption = o.id;
    },
  },
};
</script>

<style>
</style>