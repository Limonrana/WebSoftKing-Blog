require('./bootstrap');
window.Vue = require('vue')
import router from "./router";
import store from './store'
import common from "./common"
Vue.mixin(common)

// Editor.js Import
import Editor from 'vue-editor-js'
Vue.use(Editor)

//iView UI Import
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
Vue.use(ViewUI);

//Sweet Alert Import Start
import Swal from 'sweetalert2'
window.Swal = Swal

Vue.component('mainapp', require('./components/admin/mainapp'). default)
const app = new Vue({
    el: '#app',
    router,
    store
})
