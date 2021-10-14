require("./bootstrap");

window.Vue = require("vue");
import router from "./router/router";
import app_store from "./store/app_store";

const app = Vue.createApp({
    template: "<app></app>",
    components: {
        "app" : require("./components/app.vue").default,
    }
});
app.use(app_store);
app.use(router);
app.mount("#app");
