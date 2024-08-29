document.querySelectorAll('.cla-blocks-accordion-container').forEach((element, key, parent) => {
	new CLABlocksAccordion({
		container: element
	});
});