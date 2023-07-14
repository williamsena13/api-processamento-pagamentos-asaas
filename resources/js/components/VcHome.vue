<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Bem-vindo</div>

          <div class="card-body">
            <div class="row">
              <div class="col-6">
                <ul>
                  <li>Aqui</li>
                  <li>Aqui</li>
                </ul>
              </div>
              <div class="col-6">
                <router-link
                  class="btn btn-primary btn-lg btn-block"
                  to="/checkout"
                >
                  TESTE
                </router-link>
              </div>
            </div>
          </div>
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
  methods: {},
};
</script>

<style>
</style>