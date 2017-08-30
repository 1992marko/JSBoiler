import AutoModel from '../Models/AutoModel';









export default class AutiCollection extends Backbone.Collection {

	constructor(models, options = {}) {
		super(models, options);




		var auto1 = new AutoModel({
			ID: 1,
			ime: "Mercedes",
			slika: "https://assets.mbusa.com/vcm/MB/DigitalAssets/Designo/exterior/CL63_paint_MysticRed.png",
			boja: "Crveni"
		});

		var auto2 = new AutoModel({
			ID: 2,
			ime: "Bmw",
			slika: "https://www.bmw.hr/content/dam/bmw/common/all-models/m-series/m6-convertible/2015/model-card/BMW-M6-Convertible_ModelCard.png",
			boja: "Plavi"
		});

		var auto3 = new AutoModel({
			ID: 3,
			ime: "Ferrari",
			slika: "http://buyersguide.caranddriver.com/media/assets/submodel/7554.jpg",
			boja: "Sivi"
		});

		this.add(auto1);
		this.add(auto2);
		this.add(auto3);

	}

	url() {
		return "/page/settings";
	}

	get model() {
		return AutoModel;
	}

	parse(data) {
		return data.AutoModel;
	}

}