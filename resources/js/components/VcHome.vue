<template>
  <div></div>
</template>

<script>
import axios from "axios";

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