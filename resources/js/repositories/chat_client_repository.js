export default class ChatClientRepository {
    constructor() {
        this.on_message_listeners = [];
    }

    add_on_message_listener(on_message_listener) {
        this.on_message_listeners.push(on_message_listener);
    }

    connect() {
        this.conn = new WebSocket("ws://localhost:8001/");
        this.conn.onmessage = this._on_message_handler.bind(this);
        this.conn.onopen = () => {
            setInterval(() => this.conn.send("aaaasdasdsa " + Date.now()), 500);
        };
        this.conn.onerror = (...args) => {

            console.log('close', args);
        };
    }

    _on_message_handler(message) {
        console.log(message);

        for (let listener of this.on_message_listeners) {
            listener(message);
        }
    }
}
