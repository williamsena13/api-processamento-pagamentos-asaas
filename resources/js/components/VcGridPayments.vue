<script>
export default {
  beforeRouterEnter(to, from, next) {},
  components: {},
  data() {
    return {
      payments: [],
    };
  },
  created() {},
  watch: {},
  computed: {
    getClientes() {
      return this.clientes;
    },
  },
  methods: {
    async findPayments() {
      try {
        this.$http
          .get("/payments")
          .then((response) => {
            console.log("Sucesso ao AUTENTICAR");
            console.log(response);
            if (response.status == 200) {
              let resposta = response.data;
              if (resposta.data) {
                localStorage.setItem(
                  "search_payments",
                  JSON.stringify(response.data.data)
                );
                console.log("if", response.data.data);
                let payments = response.data.data;
                payments.forEach((payment) => {
                  console.log(payment);
                });
              } else {
                console.log("else", response.data);
                JSON.stringify(response.data);
              }
              document
                .getElementById("btn-recarregar-dados-GridPayments")
                .click();
            }
          })
          .catch((error) => {
            console.log("Erro ao buscar");
            console.log(error);
          });
      } catch (error) {
        console.log("Não foi possível buscar dados de clientes");
        console.log(error);
      }
    },
  },
  async mounted() {
    setTimeout(() => {
      this.findPayments();
    }, 1000);
  }, // mounted()
};
</script>
<template>
  <div>
    <vc-grid-padrao
      localData="search_payments"
      componentName="GridPayments"
      :refreshFunction="findPayments"
      :header="[
        {
          field: 'anticipable',
          title: ' Antecipável?',
          class: 'text-center',
          condition: true,
          verdade: 'Sim',
          falso: 'Não',
        },
        {
          field: 'anticipated',
          title: ' Antecipado?',
          class: 'text-center',
          condition: true,
          verdade: 'Sim',
          falso: 'Não',
        },
        { field: 'value', title: 'Valor da Cobrança', reais: true },

        { field: 'billingType', title: ' Tipo de cobrança ' },
        {
          field: 'clientPaymentDate',
          title: 'Pago',
          datetime: true,
        },
        { field: 'description', title: ' Descrição ' },
        // DATAS
        { field: 'dateCreated', title: 'Gerado', datetime: true },
        { field: 'dueDate', title: ' Vencimento', datetime: true },
        { field: 'creditDate', title: 'Data de crédito', datetime: true },
        //

        { field: 'installmentNumber', title: ' Número da parcela ' },
        { field: 'interestValue', title: ' Valor de juros ' },
        { field: 'invoiceNumber', title: ' Número da fatura ' },
        {
          field: 'invoiceUrl',
          title: 'URL da fatura ',
          class: 'col-2 col-md-2 col-sm-2 col-xs-2 text-center',
          link: true,
        },
        { field: 'bankSlipUrl', title: 'Boleto Bancário' },

        {
          field: 'lastBankSlipViewedDate',
          title: ' Data da última visualização do boleto bancário ',
        },
        {
          field: 'lastInvoiceViewedDate',
          title: ' Data da última visualização da fatura ',
        },

        { field: 'nossoNumero', title: ' Nosso Número ' },
        { field: 'object', title: ' Objeto ' },
        { field: 'paymentDate', title: 'Pago', datetime: true },
        { field: 'paymentLink', title: ' Link de pagamento ' },
        { field: 'pixTransaction', title: ' Transação Pix ' },
        { field: 'postalService', title: 'Serviço postal' },
        { field: 'status', title: ' Status ' },
        {
          field: 'transactionReceiptUrl',
          title: ' URL do recibo da transação ',
        },
      ]"
    ></vc-grid-padrao>
  </div>
</template>