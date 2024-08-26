import React from 'react';
import { __ } from '@wordpress/i18n';
import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { Button, ResponsiveWrapper } from '@wordpress/components';

import './editor.css';

export function BasicMediaUpload({
	allowedTypes = ['image'],
	mediaId = 0,
	mediaUrl = '',
	onChange = (media) => {}
}) {
	return (
		<div className="cla-blocks-editor-block-image">
			<MediaUploadCheck>
				<MediaUpload allowedTypes={allowedTypes} onSelect={onChange} value={mediaId} render={({open}) => (
					<Button className={mediaId == 0 ? 'editor-post-featured-image__toggle' : 'editor-post-featured-image__preview'} onClick={open}>
						{mediaId == 0 && __('Choose an image', 'cla-blocks')}
						{mediaId != 0 && 
							<ResponsiveWrapper naturalWidth={3000} naturalHeight={2000}>
								<img src={mediaUrl} />
							</ResponsiveWrapper>
						}
					</Button>
				)}/>
			</MediaUploadCheck>
			{mediaId != 0 && 
				<MediaUploadCheck>
					<div className="cla-blocks-editor-block-image__actions">
						<MediaUpload title={__('Replace image')} value={mediaId} onSelect={onChange} allowedTypes={allowedTypes} render={({open}) => (
							<Button onClick={open} className="editor-post-featured-image__action">{__('Replace', 'cla-blocks')}</Button>
						)}/>
						<Button onClick={() => {onChange({id:0, url: ''})}} className="editor-post-featured-image__action">{__('Remove', 'cla-blocks')}</Button>
					</div>
				</MediaUploadCheck>
			}
		</div>
	);
};