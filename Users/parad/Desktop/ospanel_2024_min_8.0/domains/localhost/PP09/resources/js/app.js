import { createApp } from 'vue';
import App from './components/App.vue';
import router from './router';

// Импорт глобальных стилей
import '../css/style.css'; // Убедитесь, что путь правильный

const app = createApp(App);
app.use(router);
app.mount('#app');