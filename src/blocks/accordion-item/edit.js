import { __ } from '@wordpress/i18n';
import { InnerBlocks, InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import { useEffect } from '@wordpress/element';
import { RichTextHeading } from '../../components/richtext-heading/richtext-heading';

import './editor.css';

export default function Edit(props) {
	const { attributes, clientId, setAttributes } = props;
	const blockProps = useBlockProps(
		{
			className: ["cla-blocks-accordion-item-container"]
		}
	);

	useEffect(() => {
		if (attributes.id !== clientId) {
			setAttributes({id: clientId.replace('-', '').substr(0, 10)});
		}
	}, []);

	return (
		<div { ...blockProps }>
			<InspectorControls>
				<PanelBody title={__('Settings', 'cla-blocks')} initialOpen={true}>
					<ToggleControl label="Expanded" help={attributes.expanded ? "Is expanded by default" : "Is collapsed by default"} checked={attributes.expanded} onChange={(newValue) => {setAttributes({expanded: newValue})}} />
				</PanelBody>
			</InspectorControls>
			<div className="cla-blocks-accordion-item">
				<button className="cla-blocks-accordion-item__button" type="button" aria-controls={"cla-blocks-accordion-item__content-" + attributes.id} aria-expanded={attributes.expanded}>
					<RichTextHeading
						className="cla-blocks-accordion-item__button-heading"
						value={attributes.title}
						headingLevel={attributes.titleHeadingLevel}
						onChange={(newValue) => {setAttributes({title: newValue})}}
						onChangeHeadingLevel={(newValue) => {setAttributes({titleHeadingLevel: newValue})}}
					/>
					<span className="cla-blocks-accordion-item__button-status">-</span>
				</button>
				<div id={"cla-blocks-accordion-item__content-" + attributes.id} className="cla-blocks-accordion-item__content" role="region" aria-labelledby={"cla-blocks-accordion-item__button-heading" + attributes.id}>
					<InnerBlocks allowedBlocks={props.attributes.allowedBlocks} template={[['core/paragraph', {placeholder: 'Content...'}]]}/>
				</div>
			</div>
		</div>
	);
};