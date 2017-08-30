import BookLook from '../../views/BookLook/BookLook';
import PhoneBookViewTemplate from '../../views/BookLook/PhoneBookViewTemplate.hbs';

export default class PhoneBookView extends Marionette.View {

	constructor(options = {}) {
		super(options);

		this.template = PhoneBookViewTemplate;
	}

	events() {
		return {

		};
	}

	className() {
		//return "row";
	}

	regions() {
		return {
			list: "#list"
		};
	}

	onRender() {
		this.showChildView("list", new BookLook());
	}

}