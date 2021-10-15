<template>
	<div class="m-auto max-w-screen-lg">
		<div class="flex flex-col text-gray-800">
			<div class="p-1 bg-gray-300 rounded m-1">Laravel Livechat</div>
			<div class="flex flex-col flex-auto p-1">
				<div class="flex flex-col items-center flex-auto rounded bg-gray-100 p-1">
					<div class="w-full">
						<div class="flex flex-row items-center w-full">
							<div class="flex-grow">
								<div class="flex items-center border h-12 px-2 rounded">
									{{ name }}
								</div>
							</div>
							<div class="ml-1">
								<button
									@click.prevent="sort_name()"
									class="flex h-12 items-center justify-center bg-indigo-500 hover:bg-indigo-600 rounded text-white px-4 py-1 flex-shrink-0"
								>
									<RefreshIcon class="h-5 w-5"></RefreshIcon>
								</button>
							</div>
						</div>
					</div>

					<div class="mt-2 w-full">
						<button
							@click.prevent="enter()"
							class="flex w-full h-12 items-center justify-center bg-indigo-500 hover:bg-indigo-600 rounded text-white px-4 py-1 flex-shrink-0"
						>
							Enter
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { mapActions } from 'vuex';
import animals from '@/utils/animals';
import adjetives from '@/utils/adjetives';
import { RefreshIcon } from '@heroicons/vue/outline';

export default {
	data() {
		return {
			name: null,
		};
	},

	mounted() {
		this.sort_name();

		// this.$nextTick(() => this.enter());
	},

	methods: {
		sort_name() {
			this.name = [adjetives[Math.floor(adjetives.length * Math.random())], animals[Math.floor(animals.length * Math.random())]].join(' ').toUpperCase();
		},

		async enter() {
			let entered = await this.do_enter(this.name);
			if (!entered) return;

			let connected = await this.do_connect();
			if (!connected) return;

			this.$router.push('/chat');
		},

		...mapActions(['do_enter', 'do_connect']),
	},

	components: {
		RefreshIcon,
	},
};
</script>

<style>
</style>
