import { __ } from '@wordpress/i18n';
import { getSpacingPresetCssVar, BlockControls, InnerBlocks, useBlockProps } from '@wordpress/block-editor';
import { ToolbarGroup } from '@wordpress/components';
import { HeadingLevelDropdownMenu } from '../../components/heading-level-dropdown-menu/heading-level-dropdown-menu';

import './editor.css';

export default function Edit(props) {
	const { attributes, setAttributes } = props;
	const blockProps = useBlockProps(
		{
			className: ["cla-blocks-heading-group-container", (attributes.orientation === 'vertical' ? "cla-blocks-heading-group-container--orientation-vertical" : "cla-blocks-heading-group-container--orientation-horizontal")],
			style: {
				gap: attributes?.style?.spacing?.blockGap ? getSpacingPresetCssVar(attributes.style.spacing.blockGap) : 'initial'
			}
		}
	);
	const TagName = attributes.tagName;
	const { style, ...otherBlockProps } = blockProps;
	const { gap, ...otherStyles } = style || {};

	return (
		<div { ...otherBlockProps } style={otherStyles}>
			<BlockControls>
				<ToolbarGroup>
					<HeadingLevelDropdownMenu headingLevel={attributes.level} onChangeHeadingLevel={(newValue) => {setAttributes({level: newValue, tagName: 'h' + newValue})}} />
				</ToolbarGroup>
			</BlockControls>
			<TagName className="cla-blocks-heading-group" style={{gap}}>
				<InnerBlocks allowedBlocks={props.attributes.allowedBlocks} template={[['core/paragraph', {}]]}/>
			</TagName>
		</div>
	);
};