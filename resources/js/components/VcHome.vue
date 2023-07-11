<template>
  <div></div>
</template>

<script>
import Axios from "axios";

export default {
  data() {
    return {
      loading: false,
    };
  },
  mounted() {
    console.log("Component mounted.");
    this.getCustomers();
  },
  watch: {
    getLoading() {
      return this.loading;
    },
  },
  methods: {
    getCustomers() {
      this.loading = true;
      try {
        const config = {
          url: "https://www.asaas.com/api/v3/customers",
          method: "GET",
          headers: {
            access_token:
              "$aact_YTU5YTE0M2M2N2I4MTliNzk0YTI5N2U5MzdjNWZmNDQ6OjAwMDAwMDAwMDAwMDAzMjM3OTI6OiRhYWNoX2U2NjY0NDQ3LWYyYjktNGIwNy04MDNiLWYwODFlMWI5OTg5MA==",
          },
        };

        Axios(config)
          .then((response) => {
            console.log(response.data);
          })
          .catch((error) => {
            console.error(error);
          });
      } catch (error) {
        console.log("ERRO AO REQUISITAR CLIENTES");
        console.log(error);
      }
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
</style>