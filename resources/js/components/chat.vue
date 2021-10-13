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
					<div class="flex flex-col h-full overflow-x-auto mb-4">
						<div class="flex flex-col h-full">
							<div class="grid grid-cols-12 gap-y-2">
								<template
									:key="i"
									v-for="(message, i) in messages"
								>
									<div
										class="
											col-start-1 col-end-8
											p-3
											rounded-lg
										"
                                        :class=" message.from_me === true ? 'col-start-6 col-end-13 p-3 rounded-lg' : 'col-start-1 col-end-8 p-3 rounded-lg' "
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
										<div
											class="
												relative
												ml-3
												text-sm
												bg-white
												py-2
												px-4
												shadow
												rounded-xl
											"
										>
											{{ message }}
										</div>

										<!-- <div>
									<div class="text-xl font-medium text-black">
										{{ "anom alpaca" }}
									</div>
									<p class="text-gray-500">{{ message }}</p>
								</div> -->
									</div>
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
							<div class="flex-grow ml-4">
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

	methods: {
		send_message() {
			this.$store.dispatch("send_message", this.message);
			this.message = "";
		},
		...mapActions(["connect"]),
	},
};
</script>

<style>
</style>
