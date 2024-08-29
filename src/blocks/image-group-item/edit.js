import { __ } from '@wordpress/i18n';
import { InnerBlocks, InspectorControls, MediaPlaceholder, useBlockProps } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';
import { BasicMediaUpload } from '../../components/basic-media-upload/basic-media-upload';

import './editor.css';

export default function Edit(props) {
	const { attributes, setAttributes } = props;
	const blockProps = useBlockProps(
		{
			className: ["cla-blocks-image-group-item-container"]
		}
	);
	const { style, ...otherBlockProps } = blockProps;
	const { aspectRatio, ...otherStyles } = style || {};

	return (
		<div { ...otherBlockProps } style={otherStyles}>
			<InspectorControls>
				<PanelBody title={__('Image', 'cla-blocks')} initialOpen={true}>
					<BasicMediaUpload mediaId={attributes.mediaId} mediaUrl={attributes.mediaUrl} onChange={(media) => {setAttributes({mediaId: media.id, mediaUrl: media.url})}} />
				</PanelBody>
			</InspectorControls>
			<div className="cla-blocks-image-group-item">
				{attributes.mediaId != 0 && 
					<figure className="cla-blocks-image-group-item__media-container">
						<img className="cla-blocks-image-group-item__media" src={attributes.mediaUrl} style={{aspectRatio}} />
					</figure>
				}
				{attributes.mediaId == 0 && 
					<MediaPlaceholder
						onSelect={(media) => {setAttributes({mediaId: media.id, mediaUrl: media.url})}}
						value={{id: attributes.mediaId}}
					/>
				}
				<div className="cla-blocks-image-group-item__content">
					<InnerBlocks allowedBlocks={props.attributes.allowedBlocks} template={[['core/heading', {content: 'Title', level: 3, fontFamily: "serif-1", fontSize: "300", style: {typography: {fontStyle: "normal", fontWeight: "400"}}}], ['core/paragraph', {placeholder: 'Content...'}]]}/>
				</div>
			</div>
		</div>
	);
};