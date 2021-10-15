<template>
	<div class="flex items-center justify-center col-start-1 col-end-13 text-gray-500 text-xs">
		{{ message.message }}
	</div>
</template>

<script>
export default {
	props: {
		message: null,
	},
};
</script>

<style>
</style>
