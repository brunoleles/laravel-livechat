<template>
	<div
		:class="
			message.from_me === true
				? 'flex items-center col-start-2 col-end-13 p-1 rounded-lg relative md:col-start-6'
				: 'flex items-center col-start-1 col-end-12 p-1 rounded-lg relative md:col-end-8'
		"
	>
		<div
        v-if="false"
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
		<div class="relative flex-grow ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
            <div v-if="message.from_me === true" >
                <span class="font-semibold">me</span>
            </div>
            <div v-if="message.from_id" >
                <span class="font-semibold">{{ message.from_name }}</span> @ <span class="font-light">{{message.from_id}}</span>
            </div>
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
