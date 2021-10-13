<template>
	<div>
		<chat></chat>
		{{ messages }}
	</div>
</template>

<script>
import chat from "./chat.vue";
import ChatClientRepository from "../repositories/chat_client_repository";
import { mapActions, mapState } from "vuex";

export default {
	data() {
		return {
			// messages: [],
			// chat_client: new ChatClientRepository(),
		};
	},

	mounted() {
		// this.connect();
		// this.chat_client = new ChatClientRepository();
		// this.chat_client.add_on_message_listener(
		// 	(message) => (this.messages = [...this.messages, message])
		// );
		// this.chat_client.connect();
	},

	computed: {
		...mapState(["messages"]),
	},

	methods: {
		...mapActions(["connect"]),
	},

	components: { chat },
};
</script>

<style>
</style>
