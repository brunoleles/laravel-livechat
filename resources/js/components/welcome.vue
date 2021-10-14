<template>
	<div class="m-auto max-w-screen-lg">
		<div
			class="
				flex flex-row
				bg-gray-100
				items-center
				h-16
				rounded-xl
				bg-white
				w-full
				px-4
			"
		>
			<div class="flex-grow">
				{{ name }}
				<!-- <input
					v-model="name"
					placeholder="pseudoname"
					class="
						flex
						w-full
						border
						rounded-xl
						focus:outline-none
						focus:border-indigo-300
						px-2
						h-10
					"
				/> -->
			</div>
			<div class="ml-4">
				<button
					@click.prevent="sort_name()"
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
					<RefreshIcon class="h-5 w-5"></RefreshIcon>
				</button>
			</div>
			<div class="ml-4">
				<button
					@click.prevent="enter()"
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
					Enter
				</button>
			</div>
		</div>
	</div>
</template>

<script>
import { mapActions } from "vuex";
import animals from "../utils/animals";
import adjetives from "../utils/adjetives";
import { RefreshIcon } from "@heroicons/vue/outline";

console.log(RefreshIcon);

export default {
	data() {
		return {
			name: null,
		};
	},

	mounted() {
		this.sort_name();

		this.$nextTick(() => {
			// this.enter();
		});
	},

	methods: {
		sort_name() {
			this.name = [
				adjetives[Math.floor(adjetives.length * Math.random())],
				animals[Math.floor(animals.length * Math.random())],
			]
				.join(" ")
				.toUpperCase();
		},

		async enter() {
			let entered = await this.do_enter(this.name);
			if (!entered) return;

			let connected = await this.do_connect();
			if (!connected) return;

			this.$router.push("/chat");
		},

		...mapActions(["do_enter", "do_connect"]),
	},

	components: {
		RefreshIcon,
	},
};
</script>

<style>
</style>
