import homeTemplate from './NoviAutoTemplate.hbs';
var test;

export default class NoviAuto extends Marionette.View {
	constructor(options = {}) {
		super(options);
		this.template = homeTemplate;
		let promise = fetch("/Auti.json")
		promise.then((response) => {
			this.auti = response.json()
		})

	}

	onRender() {
		setTimeout(() => {
			this.auti.then((data) => {
				console.log(data);
				console.log(this.el.getElementsByClassName("tekst"));
			})

		}, 2000)
	}
	onShow() {
		debugger;
	}

}