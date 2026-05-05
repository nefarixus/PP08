import { createApp } from 'vue';
import App from './components/App.vue';
import router from './router';

// Import global styles
import '../../styles/style.css';

const app = createApp(App);

app.use(router);

app.mount('#app');