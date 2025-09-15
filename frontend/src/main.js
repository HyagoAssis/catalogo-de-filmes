import './assets/main.css';

import { createApp } from 'vue';
import App from './App.vue';
import { router } from '@/router/index.js';
import { User } from '@/global-scopes/user.js';

const app = createApp(App).use(router);

User.setSession();
app.config.globalProperties.$user = User;

app.mount('#app');
