import App from "./components/App";
import store from './store'
import {createApp} from "vue";
import router from "./router";

require('./bootstrap');

createApp(App)
    .use(router)
    .use(store)
    .mount('#app');
