import AddMovieViewTemplate from './AddMovieViewTemplate.hbs';
import Binder from '../../../Helpers/Binder';
import Movie from '../../../Models/Movie';
import Backbone from 'backbone';

export default class AddMovieView extends Marionette.View {

	constructor(options = {}) {
		super(options);
		this.model = new Movie();
		this.template = AddMovieViewTemplate;

	}

	events() {
		return {
			"click .delete": "removePerson",
			"click .save": "save",
			"click .cancel": "cancel"
		};
	}

	onRender() {}

	removePerson() {
		this.model.destroy();
	}

	save() {
		Binder.formToModel(this.$el, this.model, true);
		this.model.save(null, {
			success: () => {
				Backbone.history.navigate("/movies", true);
			}
		});
	}

	cancel() {
		Backbone.history.navigate("/movies", true);
	}

}