<template>
	<div
		:class="
			message.from_me === true
				? 'flex items-center col-start-6 col-end-13 p-3 rounded-lg relative'
				: 'flex items-center col-start-1 col-end-8 p-3 rounded-lg relative'
		"
	>
		<div
			class="
				flex
				items-center
				justify-center
				h-10
				w-10
				rounded-full
				bg-indigo-500
				flex-shrink-0
			"
		>
			AL
		</div>
		<div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
            <div class="font-semibold">Alpaca Anom</div>
			{{ message.message }}
		</div>
	</div>
</template>

<script>
import { mapActions, mapState } from "vuex";
export default {
	props: {
		message: null,
	},

	// data() {
	// 	return {
	// 		message: "",
	// 	};
	// },

	mounted() {},

	// computed: {
	// 	...mapState(["messages"]),
	// },

	// watch: {
	// 	messages(messages) {
	// 		this.$nextTick(() => {
	// 			this.$refs.messages_container.scrollTop =
	// 				this.$refs.messages_container.scrollHeight;
	// 		});
	// 	},
	// },

	// methods: {
	// 	send_message() {
	// 		this.$store.dispatch("send_message", this.message);
	// 		this.message = "";
	// 	},
	// 	...mapActions(["connect"]),
	// },
};
</script>

<style>
</style>
