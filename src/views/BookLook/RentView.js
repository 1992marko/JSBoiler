import RentViewTemplate from '../../views/Booklook/RentViewTemplate.hbs';

export default class RentView extends Marionette.View {

	constructor(options = {}) {
		super(options);

		this.template = RentViewTemplate;
	}

	events() {
		return {
			"click .delete": "remove",
			"click .return_movie": "return_movie"
		};
	}

	//tagName(){ return "tr"; }

	className() { return "col-sm-4"; }

	remove() {
		this.model.destroy();
	}

	return_movie() {
		this.model.attributes.state = 2;
		this.model.save();
		this.$el.remove();

		// this.model.destroy();
	}

}