import React from 'react';
import { headingLevel1, headingLevel2, headingLevel3, headingLevel4, headingLevel5, headingLevel6 } from '@wordpress/icons';
import { MenuItemsChoice, ToolbarDropdownMenu } from '@wordpress/components';

const icons = [
	headingLevel1,
	headingLevel2,
	headingLevel3,
	headingLevel4,
	headingLevel5,
	headingLevel6
];

export function HeadingLevelDropdownMenu({headingLevel = 2, onChangeHeadingLevel = () => {}}) {
	return (
		<>
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
		</>
	);
};