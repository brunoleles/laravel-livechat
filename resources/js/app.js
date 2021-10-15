require('./bootstrap');

import { createApp } from 'vue';
import router from '@/router/router';
import app_store from '@/store/app_store';

// const files = require.context('./components', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const app = createApp({
    template: '<app></app>',
    components: {
        // pages
        app: require('@/pages/app.vue').default,
        welcome: require('@/pages/welcome.vue').default,
        chat: require('@/pages/chat.vue').default,
        // components
        'message-default': require('@/components/message__default.vue').default,
        'message-notification': require('@/components/message__notification.vue').default,
    },
});
app
    //
    .use(router)
    .use(app_store)
    .mount('#app');
