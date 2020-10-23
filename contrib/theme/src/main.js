import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './App.vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueAuth from '@websanova/vue-auth'
import VueNotify from 'vue-notifyjs'
import 'vue-notifyjs/themes/default.css'


// router setup
import LightBootstrap from './light-bootstrap-main'

import routes from './routes/routes'
// plugin setup
Vue.use(VueRouter);
Vue.use(LightBootstrap);

// configure router
const router = new VueRouter({
    routes, // short for routes: routes
    linkActiveClass: 'nav-item active'
});

Vue.router = router;
axios.defaults.baseURL = typeof appUrl === 'undefined' ? `http://localhost/api` : appUrl;

Vue.use(VueAxios, axios);
Vue.use(VueNotify);
Vue.use(VueAuth, {
    auth: {
        request: function (req, token) {
            this.options.http._setHeaders.call(this, req, {Authorization: 'Bearer ' + localStorage.getItem('token')});
        },
        response: function (res) {
            if (res.data.token) {
                localStorage.setItem('token', res.data.token);
                return res.data.token;
            }
        }
    },
    http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
    router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
});

// Vue.http.interceptors.push(function (request, next) {
//     next(function (res) {
//         if (
//             res.status === 401
//         ) {
//             Vue.auth.logout({
//                 redirect: {name: 'login'}
//             });
//         }
//     });
// });

/* eslint-disable no-new */
new Vue({
    el: '#app',
    render: h => h(App),
    router
});
