import EditPersonViewTemplate from './EditPersonViewTemplate.hbs';
import Person from '../../Models/Person';
import Binder from '../../Helpers/Binder';
import Backbone from 'backbone';

export default class EditPersonView extends Marionette.View {

	constructor(options = {}) {
		super(options);

		this.model = new Person({ id: options.id });
		this.model.fetch({
			success: () => {
				this.fetched();
			}
		});

		this.template = EditPersonViewTemplate;
	}

	events() {
		return {
			"click .delete": "removePerson",
			"click .save": "save",
			"click .cancel": "cancel"
		};
	}

	onRender() {

	}

	removePerson() {
		this.model.destroy();
	}

	fetched() {
		this.render();
		Binder.modelToForm(this.$el, this.model, true);
	}

	save() {
		Binder.formToModel(this.$el, this.model, true);
		this.model.save(null, {
			success: () => {
				Backbone.history.navigate("/phoneBook", true);
			}
		});
	}

	cancel() {
		// Backbone.history.navigate("/phoneBook");
	}

}