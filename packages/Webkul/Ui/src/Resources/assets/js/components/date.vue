<template>
	<span>
		<slot>
			<input type="text" :name="name" class="control" :value="value" data-input>
		</slot>
	</span>
</template>

<script>
	import Flatpickr from 'flatpickr';
    require('flatpickr/dist/l10n/ja.js');

	export default {
		props: {
			name: String,
			value: String,
		},

		data () {
			return {
				datepicker: null
			}
		},

		mounted () {
			var this_this = this;

			var element = this.$el.getElementsByTagName('input')[0];
			this.datepicker = new Flatpickr(
				element, {
                    locale: "ja",
					altFormat: 'Y-m-d',
					dateFormat: 'Y-m-d',
					onChange: function(selectedDates, dateStr, instance) {
						this_this.$emit('onChange', dateStr)
					},
				});
		}
	};
</script>