<template>
  <div>
    <div
      class="btn_additem"
      id="btn_additem"
      data-toggle="modal"
      data-target="#modalAdd"
    >
      <div>
        <button
          class="plus text-white"
          type="button"
          style="border: none; background-color: transparent"
        >
          <i class="fa fa-plus"></i>
        </button>
      </div>
    </div>

    <div
      class="modal fade"
      id="modalAdd"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modalAddLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalAddLabel">Adicionar Cobrança</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h4 class="mb-3" style="padding-top: 20px">Forma de Pagamento</h4>
            <vc-payment-options></vc-payment-options>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Cancelar
            </button>
            <button type="button" class="btn btn-success">Confirmar</button>
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
.btn_additem {
  position: fixed;
  background-color: #1777d9;
  border-radius: 50px;
  float: right;
  bottom: 20px;
  right: 20px;
  width: 70px;
  height: 70px;
  z-index: 275;
  text-align: center;
  color: #fff;
  box-shadow: 2px 2px 5px 0px #53a4f5;
} /* .btn_additem */

.plus {
  position: relative;
  font-size: 44px;
  align-items: center;
} /* .plus */
</style>