import { __ } from '@wordpress/i18n';
import { BlockControls, InnerBlocks, InspectorControls, MediaUpload, MediaUploadCheck, URLInput, URLInputButton, URLPopover, useBlockProps } from '@wordpress/block-editor';
import { Button, PanelBody, ResponsiveWrapper, TextControl, ToggleControl, ToolbarGroup } from '@wordpress/components';

import './editor.css';

import metadata from './block.json';

export default function Edit(props) {
	const { attributes, setAttributes } = props;
	const blockProps = useBlockProps(
		{
			className: ["cla-blocks-sequence-container"]
		}
	);

	return (
		<div { ...blockProps }>
			<div className="cla-blocks-sequence">
				<InnerBlocks allowedBlocks={props.attributes.allowedBlocks} template={[['cla-blocks/sequence-item', {lock: {move: true, remove: true}}]]}/>
			</div>
		</div>
	);
};