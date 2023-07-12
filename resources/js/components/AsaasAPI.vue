<template>
  <div>
    <button @click="getCustomers">Obter Clientes</button>
    <ul>
      <li v-for="customer in customers" :key="customer.id">
        {{ customer.name }} - {{ customer.email }}
      </li>
    </ul>
  </div>
</template>
  
  <script>
import axios from "axios";

export default {
  data() {
    return {
      customers: [],
    };
  },
  methods: {
    getCustomers() {
      axios
        .get("https://sandbox.asaas.com/api/v3/customers", {
          headers: {
            "Content-Type": "application/json",
            access_token:
              "$aact_YTU5YTE0M2M2N2I4MTliNzk0YTI5N2U5MzdjNWZmNDQ6OjAwMDAwMDAwMDAwMDAwNTg3NTM6OiRhYWNoX2M3NDU5ZDlhLTBiMDEtNDdiMC05NzJiLWE3N2ZkZDcwMzc2ZQ==",
          },
        })
        .then((response) => {
          console.log("RESPONSE");
          console.log(response);
          this.customers = response.data.data;
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>
  