
import Vue from 'vue';
import Router from 'vue-router';

const routes = [
    

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
