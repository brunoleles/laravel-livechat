import { createMemoryHistory, createRouter, createWebHistory } from "vue-router";
import Welcome from "@/pages/welcome";
import Chat from "@/pages/chat";

const router = createRouter({
    history: createMemoryHistory("/"),
    routes: [
        { path: "/", component: Welcome },
        { path: "/chat", component: Chat },
    ],
});
export default router;
