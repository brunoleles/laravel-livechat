import { createStore } from "vuex";
import ChatClientRepository from "../repositories/chat_client_repository";

const app_store = createStore({
    state() {
        return {
            chat_client: new ChatClientRepository(),
            messages: [],
        };
    },

    actions: {
        connect({ state }) {
            state.chat_client.connect();
        },
    },
});

export default app_store;
