
import Vue from 'vue';
import Router from 'vue-router';

const routes = [
    { path : '/home' , name: 'home', component: require('../../components/VcHome.vue').default , meta: { requeresAuth: true }},
    { path : '/checkout' , name: 'checkout', component: require('../../components/VcFormCheckout.vue').default , meta: { requeresAuth: true }},
    { path : '/obrigado' , name: 'thanks', component: require('../../components/VcFormTanks.vue').default , meta: { requeresAuth: true }},
];

Vue.use( Router );

const router = new Router({
    routes : routes,
    mode: "history",
    base :'/'
    //base :'/glicemia/public/'
});

router.beforeEach( (to, from, next) =>  {
    next();
})

export default router;
