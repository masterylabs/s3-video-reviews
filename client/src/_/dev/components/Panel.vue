<template>
	<v-card
		:dark="dark"
		:color="color"
		:style="
			`position:${absolute ? 'absolute' : 'fixed'};${right ? 'right' : 'left'}:20px;${
				top ? 'top' : 'bottom'
			}:20px`
		"
	>
		<v-card-title v-if="title">{{ title }}</v-card-title>
		<v-card-text>
			<dev-raw if="data" :value="data" />
			<slot />
		</v-card-text>
	</v-card>
</template>

<script>
export default {
	props: {
		top: Boolean,
		right: Boolean,
		absolute: Boolean,
		dark: Boolean,
		title: {
			type: String,
			default: '',
		},
		color: {
			type: String,
			default: '',
		},
		data: {
			type: [Object, Array, String, Number],
			default: null,
		},
	},
}
</script>
