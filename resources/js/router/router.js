import { createMemoryHistory, createRouter, createWebHistory } from "vue-router";
import Welcome from "../components/welcome";
import Chat from "../components/chat";

const router = createRouter({
    history: createMemoryHistory("/"),
    routes: [
        { path: "/", component: Welcome },
        { path: "/chat", component: Chat },
    ],
});
export default router;
