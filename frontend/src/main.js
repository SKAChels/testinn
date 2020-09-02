import 'core-js/stable';
import Vue from 'vue';
import './plugins';
import App from './App.vue';
import router from './router';
import config from './config/config';

Vue.prototype.$config = config;

new Vue({
    el: '#app',
    router,
    render: f => f(App)
});

