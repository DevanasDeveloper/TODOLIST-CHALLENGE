import { createApp } from 'vue'
import App from './App.vue'
import store from './store';
import Toast from "vue-toastification";
import routes from './routes/routes';
import "vue-toastification/dist/index.css";

const app = createApp(App)
app.use(store);
app.use(routes);
app.use(Toast);
app.mount('#app')
