export function parse_message_event(event) {
    try {
        let data = event.data;

        if (typeof data === "string") {
            data = JSON.parse(data);
        }

        return data;
    } catch (error) {
        //TODO; return paerse error message....
    }
    return void 0;
}
