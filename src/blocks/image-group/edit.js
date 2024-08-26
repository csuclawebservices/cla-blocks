import { __ } from '@wordpress/i18n';
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import { useEffect } from '@wordpress/element';

import './editor.css';

export default function Edit(props) {
	const { attributes, setAttributes } = props;
	const { maxColumns } = attributes;
	const innerBlockCount = useSelect((select) => {
		const count = select('core/block-editor').getBlockCount(props.clientId);

		return count;
	}, [props.clientId]);
	const blockProps = useBlockProps(
		{
			className: ["cla-blocks-image-group-container", "cla-blocks-image-group-max-columns-" + maxColumns]
		}
	);

	useEffect(() => {
		if (innerBlockCount !== attributes.maxColumns) {
			if (innerBlockCount < 4) {
				setAttributes({maxColumns: innerBlockCount});
			} else {
				setAttributes({maxColumns: 4});
			}
		}
	}, [innerBlockCount])
	

	return (
		<div { ...blockProps }>
			<div className="cla-blocks-image-group">
				<InnerBlocks allowedBlocks={props.attributes.allowedBlocks} template={[['cla-blocks/image-group-item'], ['cla-blocks/image-group-item'], ['cla-blocks/image-group-item']]}/>
			</div>
		</div>
	);
};