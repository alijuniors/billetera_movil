/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
// import './bootstrap';

import Vue from 'vue'
import App from './vue/App'
import router from './vue/router'
import vuetify from './vue/plugins/vuetify'
import axios from 'axios'
import VueAxios from 'vue-axios'
import '@babel/polyfill'
import 'roboto-fontface/css/roboto/roboto-fontface.css'
import '@mdi/font/css/materialdesignicons.css'

Vue.prototype.$http = axios;

new Vue({
    router,
    vuetify,
    render: h => h(App)
}).$mount('#app')