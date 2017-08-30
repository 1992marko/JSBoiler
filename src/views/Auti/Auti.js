import ListajAuteTemplate from './ListajAute.hbs';
import AutiCollection from '../../AutiCollection/AutiCollection';
import AutoModel from '../../Models/AutoModel';

export default class Auti extends Marionette.View {

	constructor(options = {}) {
		super(options);

		this.collection = App.autiCollection;

		this.template = ListajAuteTemplate;

	}

	serializeData() {
		return {
			auti: this.collection.toJSON()
		}
	}

	onRender() {
		//this.$(".dropdown").Dropdown();
	}

}