<template>
	<div>
		<chat></chat>
		<!-- {{ messages }} -->
	</div>
</template>

<script>
import chat from "./chat.vue";
import { mapActions, mapState } from "vuex";

export default {
	data() {
		return {};
	},

	mounted() {
		this.init();
	},

	computed: {
		...mapState(["messages"]),
	},

	methods: {
		...mapActions(["init"]),
	},

	components: { chat },
};
</script>

<style>
</style>
