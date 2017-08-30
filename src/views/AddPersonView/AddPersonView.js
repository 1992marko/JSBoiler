import AddPersonViewTemplate from './AddPersonViewTemplate.hbs';
import Binder from '../../Helpers/Binder';
import Person from '../../Models/Person';
import Backbone from 'backbone';

export default class AddPersonView extends Marionette.View {

	constructor(options = {}) {
		super(options);
		this.model = new Person();
		this.template = AddPersonViewTemplate;

	}

	events(){
		return{
			"click .delete" : "removePerson",
			"click .save" : "save",
			"click .cancel" : "cancel"
		};
	}

	onRender() {}

	removePerson(){
		this.model.destroy();
	}

	save(){
		Binder.formToModel(this.$el, this.model, true);
		this.model.save(null, {
			success: () => {
				 Backbone.history.navigate("/phoneBook", true);
			}
		});
	}

	cancel(){
		 Backbone.history.navigate("/phoneBook", true);
	}


}