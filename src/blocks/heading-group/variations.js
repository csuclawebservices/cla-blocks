import { __, _x } from '@wordpress/i18n';
import { row, stack } from '@wordpress/icons';

const variations = [
	{
		name: 'heading-group-row',
		title: _x('Heading Group', 'single horizontal line'),
		description: __('Arrange blocks horizontally.'),
		attributes: {
			orientation: 'horizontal'
		},
		isDefault: true,
		scope: ['block', 'inserter', 'transform'],
		isActive: (blockAttributes) => !blockAttributes.orientation || blockAttributes.orientation === 'horizontal',
		icon: row
	},
	{
		name: 'heading-group-stack',
		title: __('Heading Group Stack'),
		description: __('Arrange blocks vertically'),
		attributes: {
			orientation: 'vertical'
		},
		scope: ['block', 'transform'],
		isActive: (blockAttributes) => blockAttributes.orientation === 'vertical',
		icon: stack
	}
];

export default variations;