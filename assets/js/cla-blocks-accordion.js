class CLABlocksAccordion {
	constructor(passedArgs) {
		let args = {...{
			container: null,
			itemContainerSelector: '.cla-blocks-accordion-item-container',
			itemButtonSelector: '.cla-blocks-accordion-item__button',
			itemButtonStatusSelector: '.cla-blocks-accordion-item__button-status',
			itemContentSelector: '.cla-blocks-accordion-item__content'
		}, ...passedArgs};

		this.container = args.container;
		this.items = [];

		if (this.container instanceof HTMLElement) {
			this.container.querySelectorAll(args.itemContainerSelector).forEach((element, key, parent) => {
				this.items.push(new CLABlocksAccordionItem({container: element, itemButtonSelector: args.itemButtonSelector, itemContentSelector: args.itemContentSelector}));
			});
		}
	}
}



class CLABlocksAccordionItem {
	constructor(passedArgs) {
		let args = {...{
			container: null,
			itemButtonSelector: '.cla-blocks-accordion-item__button',
			itemButtonStatusSelector: '.cla-blocks-accordion-item__button-status',
			itemContentSelector: '.cla-blocks-accordion-item__content'
		}, ...passedArgs}

		this.container = args.container;
		this.expanded = false;
		this.button = this.container.querySelector(args.itemButtonSelector);
		this.buttonStatus = this.container.querySelector(args.itemButtonStatusSelector);
		this.content = this.container.querySelector(args.itemContentSelector);

		if (this.button instanceof HTMLElement && this.buttonStatus instanceof HTMLElement && this.content instanceof HTMLElement) {
			this.button.addEventListener('click', this.toggle.bind(this));

			if (this.button.hasAttribute('aria-expanded')) {
				this.expanded = this.button.getAttribute('aria-expanded') === 'true' ? true : false;
			}

			if (this.expanded) {
				this.expand();
			} else {
				this.collapse();
			}
		}
	}



	collapse() {
		this.expanded = false;
		this.button.setAttribute('aria-expanded', this.expanded);
		this.buttonStatus.innerText = '+';
		this.container.classList.remove('is-expanded');
		this.container.classList.add('is-collapsed');
	}



	expand() {
		this.expanded = true;
		this.button.setAttribute('aria-expanded', this.expanded);
		this.buttonStatus.innerText = '-';
		this.container.classList.remove('is-collapsed');
		this.container.classList.add('is-expanded');
	}



	toggle(event) {
		event.preventDefault();

		if (this.expanded) {
			this.collapse(event);
		} else {
			this.expand(event);
		}
	}
}