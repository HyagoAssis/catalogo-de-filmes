import './assets/main.css';

import { createApp } from 'vue';
import App from './App.vue';
import { router } from '@/router/index.js';
import { User } from '@/global-scopes/user.js';
import alerts from '@/global-scopes/alerts.js';

const app = createApp(App).use(router).use(alerts);

User.setSession();
app.config.globalProperties.$user = User;

app.mount('#app');
