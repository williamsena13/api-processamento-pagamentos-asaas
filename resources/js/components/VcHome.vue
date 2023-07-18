<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Bem-vindo</div>

          <div class="card-body">
            <div class="row">
              <div class="col-6">
                <p>
                  Esta é uma plataforma onde é possível criar cobranças através
                  do <a href="https://asaas.com/">Asaas</a>. Ao cadastrar um
                  usuário, ele é automaticamente cadastrado como cliente no
                  <b>Asaas</b>.
                </p>
                <p>
                  Para realizar os processos solicitados no desafio, clique em
                  <router-link to="/checkout"> Finalizar Compra </router-link>
                </p>
                <p>
                  Ao clicar, você será redirecionado para uma tela de checkout,
                  onde alguns dados já cadastrados serão preenchidos
                  automaticamente. Será necessário selecionar uma forma de
                  pagamento.
                </p>
                <p>
                  Se a forma de pagamento selecionada for "Boleto", o usuário
                  será redirecionado para uma tela de "Obrigado", onde poderá
                  fazer o download do boleto.
                </p>
                <p>
                  Se a forma de pagamento selecionada for "Cartão de Crédito",
                  será necessário preencher o endereço do usuário. Ao confirmar
                  o pagamento, o usuário será direcionado para a tela de
                  "Obrigado".
                </p>
                <p></p>
              </div>
              <div class="col-6">
                <h4>Tecnologias Utilizadas</h4>
                <ul>
                  <li>Laravel <small>7.0</small></li>
                  <li>Bootstrap <small>4.6.2</small></li>
                  <li>VueJS <small>2.7.14</small></li>
                  <li>MariaDB</li>
                </ul>
                <router-link
                  class="btn btn-primary btn-lg btn-block"
                  to="/checkout"
                >
                  Finalizar Compra
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