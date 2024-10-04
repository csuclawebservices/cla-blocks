=== Cla Blocks ===
Contributors:      CLA Web Services
Tags:              block
Tested up to:      6.6
Stable tag:        0.1.1
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

All CLA gutenberg project resources, such as blocks, components, and utility functions that are brand agnostic.

== Description ==

All blocks are created with only functionality in mind so that they can be used by any theme that supports the block editor.

== Changelog ==

= 0.4.0 =
* Added: A new "cla" (labelled as "College of Liberal Arts") block category and placed it at the beginning of the list so those blocks show at the beginning of the block inserter.
* Update: Blocks now have usable "example" properties in their block.json files so a useful block preview can be displayed.

= 0.3.0 =
* Added: cla-blocks/heading-group block so that multiple core/paragraph blocks (with varying styles) can be used to create a single heading text
* Added: A new HeadingLevelDropdownMenu React component used to add 1-line heading level dropdown menus to custom blocks
* Updated: The RichTextHeading React component to use the HeadingLevelDropdownMenu component
* Updated: cla-blocks/accordion-item CSS so the cursor is the pointer when focusing/hovering the accordion-item heading/button
* Updated: cla-blocks/call-to-action CSS to remove the top/bottom margin from the content container
* Fixed: cla-blocks/accordion-item to add role="region" to the content div so that the aria-labelledby can be used
* Fixed: build configuration so the plugin version is current

= 0.2.0 =
* Added: Accordion and Accordion Item blocks
* Added: Text and Heading color "supports" to the cla-blocks/call-to-action block
* Updated: cla-blocks/call-to-action and cla-blocks/image-group-item image rendering to include multiple attributes (including alt and srcset)
* Updated: InnerBlocks template for the cla-blocks/call-to-action and cla-blocks/image-group-item blocks to set default font size and weight

= 0.1.1 =
* Fixed: An error in the Update class caused by the update_multisite method

= 0.1.0 =
* Release