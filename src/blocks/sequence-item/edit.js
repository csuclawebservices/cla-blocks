import { __ } from '@wordpress/i18n';
import { BlockControls, InnerBlocks, InspectorControls, MediaUpload, MediaUploadCheck, URLInput, URLInputButton, URLPopover, useBlockProps } from '@wordpress/block-editor';
import { __experimentalHeading as Heading, Button, PanelBody, ResponsiveWrapper, TextControl, ToggleControl, ToolbarGroup } from '@wordpress/components';
import { RichTextHeading } from '../../components/richtext-heading/richtext-heading.js';

import './editor.css';

import metadata from './block.json';

export default function Edit(props) {
	const { attributes, setAttributes } = props;
	const blockProps = useBlockProps(
		{
			className: ["cla-blocks-sequence-item-container"]
		}
	);

	return (
		<div { ...blockProps }>
			<div className="cla-blocks-sequence-item">
				<RichTextHeading className="cla-blocks-sequence-item__title" value={props.attributes.title} headingLevel={props.attributes.titleHeadingLevel} onChange={(newValue) => {props.setAttributes({title: newValue})}} onChangeHeadingLevel={(newValue) => {props.setAttributes({titleHeadingLevel: newValue})}} />
				<div className="cla-blocks-sequence-item__content">
					<InnerBlocks allowedBlocks={props.attributes.allowedBlocks} template={[['core/paragraph', {content: '<strong>Subtitle</strong>'}], ['core/paragraph', {placeholder: 'Content...'}]]}/>
				</div>
			</div>
		</div>
	);
};