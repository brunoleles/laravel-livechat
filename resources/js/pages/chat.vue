<template>
	<div class="m-auto max-w-screen-lg">
		<div @click="$refs.message_input.focus()" class="flex h-screen antialiased text-gray-800">
			<div class="flex flex-row h-full w-full overflow-x-hidden">
				<div class="flex flex-col flex-auto h-full p-1">
					<div class="flex flex-col flex-auto flex-shrink-0 rounded-2xl bg-gray-100 h-full p-2">
						<div ref="messages_container" class="flex flex-col h-full overflow-x-auto mb-4">
							<div class="flex flex-col h-full">
								<div class="grid grid-cols-12 gap-y-1">
									<template :key="i" v-for="(message, i) in messages">
										<message-notification v-if="message.type === 'notification'" :message="message"></message-notification>
										<message-default v-else :message="message"></message-default>
									</template>
								</div>
							</div>
						</div>

						<form @submit.prevent="send_message">
							<div class="flex flex-row items-center rounded-xl bg-white w-full px-1 py-1">
								<div class="flex-grow">
									<input ref="message_input" v-model="message" class="flex w-full h-12 border rounded-xl focus:outline-none focus:border-indigo-300 px-2" />
								</div>
								<div class="ml-2">
									<button class="flex h-12 items-center justify-center bg-indigo-500 hover:bg-indigo-600 rounded-xl text-white px-4 py-1 flex-shrink-0">SEND</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import message__default from '@/components/message__default.vue';
import message__notification from '@/components/message__notification.vue';

export default {
	data() {
		return {
			message: '',
		};
	},

	mounted() {
		this.$nextTick(() => {
			this.$refs.message_input.focus();
		});
	},

	computed: {
		...mapState(['messages']),
	},

	watch: {
		messages(messages) {
			this.$nextTick(() => {
				this.$refs.messages_container.scrollTop = this.$refs.messages_container.scrollHeight;
			});
		},
	},

	methods: {
		send_message() {
			this.$store.dispatch('send_message', this.message);
			this.message = '';
		},
		...mapActions(['do_connect']),
	},
	components: {
		'message-default': message__default,
		'message-notification': message__notification,
	},
};
</script>

<style>
</style>
