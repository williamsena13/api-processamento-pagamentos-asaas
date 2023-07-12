<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Example Component</div>

          <div class="card-body">I'm an example component.</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AsaasService from "../src/services/AsaasService";

export default {
  components: {
    AsaasService,
  },
  mounted() {
    console.log("Vou fazer requisição de CLientes.");
    AsaasService.get("/clientes")
      .then((response) => {
        console.log(response.data);
      })
      .catch((error) => {
        console.error(error);
      });
  },
};
</script>
