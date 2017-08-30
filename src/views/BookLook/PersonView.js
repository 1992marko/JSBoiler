import PersonViewTemplate from '../../views/Booklook/PersonViewTemplate.hbs';

export default class PersonView extends Marionette.View {

	constructor(options = {}) {
		super(options);

		this.template = PersonViewTemplate;
	}

	events() {
		return {
			"click .delete": "removePerson",
			"click .edit": "editPerson",
			"click .add": "addPerson",

		};
	}

	//tagName(){ return "tr"; }

	className() { return "col-sm-4"; }

	onRender() {
		// console.log("Izrendiralo se");

	}

	removePerson() {
		this.model.destroy();

		console.log("Obrisano");

	}

	onDelete(e) {
		console.log("Obrisano");
	}

}