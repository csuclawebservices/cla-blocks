import React from 'react';
import { BlockControls, RichText } from '@wordpress/block-editor';
import { ToolbarGroup } from '@wordpress/components';
import { HeadingLevelDropdownMenu } from '../heading-level-dropdown-menu/heading-level-dropdown-menu.js';

export function RichTextHeading({value = 'Heading', headingLevel = 2, className="", onChange = () => {}, onChangeHeadingLevel = () => {}}) {
	return (
		<>
			<BlockControls>
				<ToolbarGroup>
					<HeadingLevelDropdownMenu headingLevel={headingLevel} onChangeHeadingLevel={onChangeHeadingLevel} />
				</ToolbarGroup>
			</BlockControls>
			<RichText
				className={className}
				tagName={`h${headingLevel}`}
				value={value}
				onChange={onChange}
				placeholder={`Heading Level ${headingLevel}`}
				allowedFormats={['core/bold', 'core/italic']}
			/>
		</>
		
	);
};