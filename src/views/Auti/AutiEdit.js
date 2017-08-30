import EditAuto from './EditAuto.hbs';
import AutiCollection from '../../AutiCollection/AutiCollection';
import AutoModel from '../../Models/AutoModel';

export default class AutiEdit extends Marionette.View {

	constructor(options = {}) {
		super(options);

		var model = new AutoModel();
		model.fetch({
			data: { id: options.id },
			success: function(model) {
				debugger;
			}
		});

		var mmm = App.autiCollection.findWhere({ ID: parseInt(options.id) });
		this.model = mmm;
		this.template = EditAuto;

	}

	onRender() {
		//this.$(".dropdown").Dropdown();
	}

}