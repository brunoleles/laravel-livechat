import { createStore } from "vuex";
import ChatClientRepository from "../repositories/chat_client_repository";

const STATUS_UNITIALIZED = "uninitialized";

const STATUS_INITIALIZING = "initializing";

const STATUS_INITIALIZED = "initialized";

const app_store = createStore({
    state() {
        return {
            status: STATUS_UNITIALIZED,
            chat_client: new ChatClientRepository(),
            messages: [],
        };
    },

    actions: {
        async init({ state }) {
            if (state.status != STATUS_UNITIALIZED) return;
            state.status = STATUS_INITIALIZING;

            state.chat_client.connect();
            state.chat_client.add_on_message_listener((event) => {
                state.messages = [...state.messages, event.data];
            });

            state.status = STATUS_INITIALIZED;
        },
    },
});

export default app_store;
