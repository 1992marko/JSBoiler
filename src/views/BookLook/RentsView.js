import RentsCollectionView from '../../views/BookLook/RentsCollectionView';
import RentsViewTemplate from '../../views/BookLook/RentsViewTemplate.hbs';

export default class RentsView extends Marionette.View {

	constructor(options = {}) {
		super(options);

		this.template = RentsViewTemplate;
	}

	events() {
		return {};
	}

	className() {
		//return "row";
	}

	regions() {
		return {
			list: "#rents"
		};
	}

	onRender() {
		this.showChildView("list", new RentsCollectionView());
	}

}