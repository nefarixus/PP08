import { createApp } from 'vue';
import App from './components/App.vue';
import router from './router';

// Import global styles if needed
// import '../css/app.css';

const app = createApp(App);

app.use(router);

app.mount('#app');