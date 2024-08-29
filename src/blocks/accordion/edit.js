import { __ } from '@wordpress/i18n';
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

import './editor.css';

export default function Edit(props) {
	const { attributes, setAttributes } = props;
	const blockProps = useBlockProps(
		{
			className: ["cla-blocks-accordion-container"]
		}
	);

	return (
		<div { ...blockProps }>
			<div className="cla-blocks-accordion">
				<InnerBlocks allowedBlocks={props.attributes.allowedBlocks} template={[['cla-blocks/accordion-item'], ['cla-blocks/accordion-item'], ['cla-blocks/accordion-item']]}/>
			</div>
		</div>
	);
};