import { createStore } from "vuex";
import { parse_message_event } from "@/utils/messages";

const STATUS_UNITIALIZED = "uninitialized";

const STATUS_INITIALIZING = "initializing";

const STATUS_INITIALIZED = "initialized";

const app_store = createStore({
    state() {
        return {
            status: STATUS_UNITIALIZED,
            name: null,
            access_payload: null,
            conn: null,
            messages: [],
        };
    },

    actions: {
        async do_enter({ state }, name) {
            let request_access_response = await axios.post("/api/request_access", {
                name: name,
            });

            if (request_access_response.status != 200) {
                throw new Error("unable to request access");
            }

            state.name = request_access_response.data.data.name;
            state.access_payload = request_access_response.data.data.access_payload;

            console.log("enter");
            console.log(request_access_response);
            console.log(state);

            return true;
        },

        async do_connect({ state }) {
            if (state.conn) {
                state.conn.close();
                state.conn = null;
            }

            return await new Promise((resolve, reject) => {
                state.conn = new WebSocket(`ws://localhost:8001/?access_payload=${encodeURI(state.access_payload)}`);
                state.conn.onmessage = (event) => this.dispatch("on_message_handler", event);

                state.conn.onopen = (...args) => {
                    console.log("Opened", args);
                    resolve(true);
                };

                state.conn.onerror = (...args) => {
                    console.log("Error", args);
                    reject(false);
                };
            });
        },

        on_message_handler({ state }, event) {
            console.log("received message");
            console.log(event);

            let message = parse_message_event(event);

            if (message.type == "conns") {
                //NOTE: store new connections
                return;
            }

            console.log(message);
            console.log("--");

            state.messages = [...state.messages, message];
        },

        async send_message({ state }, message) {
            if (!message) {
                return;
            }

            const message_payload = {
                access_payload: state.access_payload,
                timestamp: Date.now(),
                message: message,
            };

            // console.log(state.conn);

            state.messages = [...state.messages, { ...message_payload, from_me: true }];

            state.conn.send(JSON.stringify(message_payload));
        },
    },
});

export default app_store;
