import { __ } from '@wordpress/i18n';
import { InnerBlocks, InspectorControls, URLInput, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import { withSelect } from '@wordpress/data';
import { BasicMediaUpload } from '../../components/basic-media-upload/basic-media-upload';

import './editor.css';

const BlockEdit = (props) => {
	const {attributes, setAttributes } = props;
	const blockProps = useBlockProps(
		{
			className: ["cla-blocks-call-to-action-container", (attributes.url != "" ? "has-link" : "no-link"), (attributes.mediaId != 0 ? "has-image" : "no-image")]
		}
	);

	return (
		<div { ...blockProps }>
			<InspectorControls>
				<PanelBody title={__('Link', 'cla-blocks')} initialOpen={true}>
					<div className="cla-blocks-editor-block-link">
						<p>The entire CTA will be clickable.</p>
						<URLInput label="URL" value={attributes.url} onChange={(url, post) => setAttributes({url})}/>
						<TextControl label="Label" help="This will be used for screen readers" value={attributes.urlLabel} onChange={(value) => setAttributes({urlLabel: value})} />
					</div>
				</PanelBody>
				<PanelBody title={__('Image', 'cla-blocks')} initialOpen={true}>
					<BasicMediaUpload mediaId={attributes.mediaId} mediaUrl={attributes.mediaUrl} onChange={(media) => {setAttributes({mediaId: media.id, mediaUrl: media.url})}} />
				</PanelBody>
			</InspectorControls>
			<div className="cla-blocks-call-to-action">
				{attributes.mediaId != 0 && 
					<figure className="cla-blocks-call-to-action__media-container">
						<img className="cla-blocks-call-to-action__media" src={attributes.mediaUrl} />
					</figure>
				}
				<div className="cla-blocks-call-to-action__content">
					<InnerBlocks allowedBlocks={props.attributes.allowedBlocks} template={[['core/heading', {fontSize: "300", lock: {move: true, remove: true}}], ['core/paragraph', {}]]}/>
					{attributes.url != "" && 
						<div className="wp-block-button cla-blocks-call-to-action__link">
							<div className="wp-block-button__link">{attributes.urlLabel}</div>
						</div>
					}
				</div>
			</div>
		</div>
	);
};

const BlockEditWithSelect = withSelect((select, props) => {
	return { media: props.attributes.mediaId ? select('core').getMedia(props.attributes.mediaId) : undefined };
})(BlockEdit);

export default BlockEditWithSelect;