import { createStore } from "vuex";
import { parse_message_event } from "../utils/messages";

const STATUS_UNITIALIZED = "uninitialized";

const STATUS_INITIALIZING = "initializing";

const STATUS_INITIALIZED = "initialized";

const app_store = createStore({
    state() {
        return {
            status: STATUS_UNITIALIZED,
            conn: null,
            messages: [],
        };
    },

    actions: {
        async init({ store, state }) {
            if (state.status != STATUS_UNITIALIZED) return;
            state.status = STATUS_INITIALIZING;

            state.conn = new WebSocket("ws://localhost:8001/");
            state.conn.onmessage = (event) =>
                this.dispatch("on_message_handler", event);
            state.conn.onopen = (...args) => {
                console.log("Opened", args);
                // setInterval(() => this.conn.send("aaaasdasdsa " + Date.now()), 500);
            };
            state.conn.onerror = (...args) => {
                console.log("Error", args);
                // console.log("close", args);
            };

            state.status = STATUS_INITIALIZED;
        },

        on_message_handler({ state }, event) {
            let message = parse_message_event(event);

            state.messages = [...state.messages, message];
        },

        async send_message({ state }, message) {
            if (!message) {
                return;
            }

            const message_payload = {
                timestamp: Date.now(),
                message: message,
            };

            // console.log(state.conn);

            state.messages = [
                ...state.messages,
                { ...message_payload, from_me: true },
            ];

            state.conn.send(JSON.stringify(message_payload));
        },
    },
});

export default app_store;
