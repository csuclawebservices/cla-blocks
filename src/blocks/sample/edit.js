/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit(props) {
	const {attributes, setAttributes } = props;

	return (
		<div { ...useBlockProps() }>
			<p>{ __( 'Cla Blocks – hello from the editor!', 'cla-blocks' ) }</p>
			<h2>Multi Inner Blocks</h2>
			<div className="first-section">
				<h3>First Section</h3>
				<InnerBlocks
					allowedBlocks={['core/paragraph', 'core/image']}
					value={attributes.firstSectionContent}
					onChange={(content) => setAttributes({ firstSectionContent: content })}
					template={[['core/paragraph', {}]]}
					key="first"
				/>
			</div>
			<div className="second-section">
				<h3>Second Section</h3>
				<InnerBlocks
					allowedBlocks={['core/paragraph', 'core/image']}
					value={attributes.secondSectionContent}
					onChange={(content) => setAttributes({ secondSectionContent: content })}
					template={[['core/paragraph', {}]]}
					key="second"
				/>
			</div>
		</div>
	);
}