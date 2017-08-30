import MovieViewTemplate from '../../views/Booklook/MovieViewTemplate.hbs';

export default class MovieView extends Marionette.View {

	constructor(options = {}) {
		super(options);

		this.template = MovieViewTemplate;
	}

	events() {
		return {
			"click .delete": "removePerson",
			"click .edit": "editPerson",
			"click .add": "addPerson",
			"click .test": "test",
		};
	}

	//tagName(){ return "tr"; }

	className() { return "col-sm-4"; }

	removePerson() {
		this.model.destroy();
		// console.log("Obrisano");
	}

	onRender() {
		let rented_text = "Not rented";
		let rented_color = "green";

		if(this.model.attributes.state == 1) {
			rented_text = "Rented";
			rented_color = "red";
		}

		if(this.model.attributes.state == 2) {
		 	rented_text = "Returned";
			rented_color = "blue";
		 }

		this.$el.find(".rented").html(rented_text);
		this.$el.find(".rented").css( "color", rented_color );
		this.$el.find(".rented").css( "border-color", rented_color );
		// debugger;

		// if(this.model.attributes.state == 1) this.$el.hide();

	}

	// test(ev){
	
	// 	// var test = 2;
	// 	$(".test").removeClass("red");
	// 	$(".test").addClass("blue");
	// 	$(".test").css("border-color","");
	// 	$(".test").attr("marko", "mlad");
	
	// 	// $("div[model-id='"+proslijedjeni_parametar+"']");

	// 	this.$(".test").removeClass("blue");
	// 	this.$(".test").css("border-color","green");
	// 	this.$(".test").addClass("red");
	// 	this.$(".test").attr("marko", "mlad");
	// }

}