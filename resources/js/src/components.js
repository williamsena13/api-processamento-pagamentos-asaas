import Vue from 'vue';


Vue.component('vc-payment-options', require('../components/VcPaymentOptions.vue').default);
Vue.component('vc-modal-payments', require('../components/VcModalPayments.vue').default);

Vue.component('vc-home', require('../components/VcHome.vue').default);


Vue.component('vc-grid-padrao', require('../components/VcGridPadrao.vue').default);
Vue.component('vc-grid-payments', require('../components/VcGridPayments.vue').default);
Vue.component('vc-form-checkout', require('../components/VcFormCheckout.vue').default);
Vue.component('vc-form-credit-card', require('../components/VcFormCreditCard.vue').default);