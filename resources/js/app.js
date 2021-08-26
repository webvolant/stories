require('./bootstrap');

import Vue from 'vue';
window.Vue = require('vue');

import VueRouter from "vue-router";
import { routes } from "./routes";

Vue.use(VueRouter);
const router = new VueRouter({ mode: 'history', routes })

import PrimeVue from 'primevue/config';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import Slider from 'primevue/slider';
Vue.use(PrimeVue);
Vue.component('Dialog', Dialog);
Vue.component('Button', Button);
Vue.component('Slider', Slider);

//import Quasar from "quasar-framework";
//Vue.use(Quasar);

import QBtn from "quasar-framework/src/components/btn/QBtn";
Vue.component(QBtn.name, QBtn)

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('audio-player', require('./components/AudioPlayer.vue').default);
Vue.component('users-index', require('./components/users/Index.vue').default);

const app = new Vue({
	el: '#app',
	router:router,
	/*components: {
		QBtn,
	},*/
});


