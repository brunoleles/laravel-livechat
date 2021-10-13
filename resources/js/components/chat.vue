<template>
	<div>
		<div>
			{{ messages }}
			<template :key="i" v-for="(message, i) in messages">
				<div>{{ message }}</div>
			</template>
		</div>

		<form @submit.prevent="send_message">
			<input v-model="message" />
			<button @click="send_message">send</button>
		</form>
	</div>
</template>

<script>
import { mapActions, mapState } from "vuex";
export default {
	data() {
		return {
			message: "",
		};
	},

	mounted() {
		this.connect();
	},

	computed: {
		...mapState(["messages"]),
	},

	methods: {
		send_message() {
			this.message = "";
		},
		...mapActions(["connect"]),
	},
};
</script>

<style>
</style>
