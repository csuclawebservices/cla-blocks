import React from 'react';
import { BlockControls, RichText } from '@wordpress/block-editor';
import { headingLevel1, headingLevel2, headingLevel3, headingLevel4, headingLevel5, headingLevel6 } from '@wordpress/icons';
import { ToolbarGroup, MenuItemsChoice, ToolbarDropdownMenu } from '@wordpress/components';

const icons = [
	headingLevel1,
	headingLevel2,
	headingLevel3,
	headingLevel4,
	headingLevel5,
	headingLevel6
];

export function RichTextHeading({value = 'Heading', headingLevel = 2, className="", onChange = () => {}, onChangeHeadingLevel = () => {}}) {
	return (
		<>
			<BlockControls>
				<ToolbarGroup>
					<ToolbarDropdownMenu icon={ icons[headingLevel - 1] } label="Change level">
						{({onClose}) => (
							<>
								<MenuItemsChoice
									value={headingLevel}
									choices={ [
										{
											label: 'Heading 1',
											value: 1
										},
										{
											label: 'Heading 2',
											value: 2
										},
										{
											label: 'Heading 3',
											value: 3
										},
										{
											label: 'Heading 4',
											value: 4
										},
										{
											label: 'Heading 5',
											value: 5
										},
										{
											label: 'Heading 6',
											value: 6
										}
									] }
									onSelect={onChangeHeadingLevel}
								/>
							</>
						)}
					</ToolbarDropdownMenu>
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