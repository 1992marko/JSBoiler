import EditMovieViewTemplate from './EditMovieViewTemplate.hbs';
import Movie from '../../Models/Movie';
import Binder from '../../Helpers/Binder';
import Backbone from 'backbone';

export default class EditMovieView extends Marionette.View {

	constructor(options = {}) {
		super(options);

		this.model = new Movie( { id:options.id } );
		this.model.fetch({
			success: () => {
				this.fetched();
			}
		});

		this.template = EditMovieViewTemplate;
	}

	events(){
		return{
			"click .delete" : "removePerson",
			"click .save" : "save",
			"click .cancel" : "cancel"
		};
	}

	onRender() {


	}

	removePerson(){
		this.model.destroy();
	}


	fetched(){
		this.render();
		Binder.modelToForm(this.$el, this.model, true);
	}

	save(){
	
		Binder.formToModel(this.$el, this.model, true);
		this.model.save(null, {
			success: () => {
				Backbone.history.navigate("/movies", true);
			}
		});
	}

	cancel(){
		// Backbone.history.navigate("/phoneBook");
	}


}