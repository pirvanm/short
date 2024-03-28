import './bootstrap';
import {createApp} from 'vue'

import VueClipboard from 'vue3-clipboard'


import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import App from './App.vue'


const app = createApp(App)

app.use(VueSweetalert2);
app.use(VueClipboard, {
    autoSetContainer: true,
    appendToBody: true,
  })


app.mount('#app');