<template>
	<div class="flex h-screen antialiased text-gray-800">
		<div class="flex flex-row h-full w-full overflow-x-hidden">
			<div class="flex flex-col flex-auto h-full p-6">
				<div
					class="
						flex flex-col flex-auto flex-shrink-0
						rounded-2xl
						bg-gray-100
						h-full
						p-4
					"
				>
					<div
						ref="messages_container"
						class="flex flex-col h-full overflow-x-auto mb-4"
					>
						<div class="flex flex-col h-full">
							<div class="grid grid-cols-12 gap-y-2">
								<template
									:key="i"
									v-for="(message, i) in messages"
								>
									<message-notification
										v-if="message.type === 'notification'"
										:message="message"
									></message-notification>

									<message-default
										v-else
										:message="message"
									></message-default>

									<!-- <div>
									<div class="text-xl font-medium text-black">
										{{ "anom alpaca" }}
									</div>
									<p class="text-gray-500">{{ message }}</p>
								</div> -->
									<!-- </div> -->
								</template>
							</div>
						</div>
					</div>

					<form @submit.prevent="send_message">
						<div
							class="
								flex flex-row
								items-center
								h-16
								rounded-xl
								bg-white
								w-full
								px-4
							"
						>
							<div class="flex-grow">
								<input
									v-model="message"
									class="
										flex
										w-full
										border
										rounded-xl
										focus:outline-none
										focus:border-indigo-300
										pl-4
										h-10
									"
								/>
							</div>
							<div class="ml-4">
								<button
									class="
										flex
										items-center
										justify-center
										bg-indigo-500
										hover:bg-indigo-600
										rounded-xl
										text-white
										px-4
										py-1
										flex-shrink-0
									"
								>
									SEND
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import message__default from "./message__default.vue";
import message__notification from "./message__notification.vue";

export default {
	data() {
		return {
			message: "",
		};
	},

	mounted() {},

	computed: {
		...mapState(["messages"]),
	},

	watch: {
		messages(messages) {
			this.$nextTick(() => {
				this.$refs.messages_container.scrollTop =
					this.$refs.messages_container.scrollHeight;
			});
		},
	},

	methods: {
		send_message() {
			this.$store.dispatch("send_message", this.message);
			this.message = "";
		},
		...mapActions(["connect"]),
	},
	components: {
		"message-default": message__default,
		"message-notification": message__notification,
	},
};
</script>

<style>
</style>
