/*jshint esnext: true */
import $ from 'jquery';

export default class Binder {

	constructor() {

	}

	static formToModel(el, _model, useId) {
		let search = (useId) ? "[ID]" : "[data-model]";
		let replace = (useId) ? "ID" : "data-model";
		el.find(search).each((index, value) => {

			if ($(value).is(":text") || $(value).is("textarea") || $(value).is(":password") || $(value).is("select")) {
				_model.set($(value).attr(replace), $(value).val());
			}

			if ($(value).is(":radio") || $(value).is(":checkbox")) {
				_model.set($(value).attr(replace), $(value).is(':checked') ? $(value).val() : "");
			}
		});
	}

	static modelToForm(el, _model, useId) {
		let search = (useId) ? "[ID]" : "[data-model]";
		let replace = (useId) ? "ID" : "data-model";

		el.find(search).each((index, value) => {

			var val;

			if ($(value).attr(replace).indexOf(".") > -1) {

				var res = $(value).attr(replace).split(".");
				var model = res[0];

				var obj = _model.get(model);

				//Get object properties
				var prop, props = $(value).attr(replace).split('.');
				props.shift();
				for (var i = 0, iLen = props.length - 1; i < iLen; i++) {
					prop = props[i];

					var candidate = obj[prop];
					if (candidate !== undefined) {
						obj = candidate;
					} else {
						break;
					}
				}

				val = obj[props[i]];

			} else {
				val = _model.get($(value).attr(replace));
			}

			if ($(value).is(":text") || $(value).is("textarea") || $(value).is(":password") || $(value).is("select")) {
				$(value).val(val);
			}
			else if ($(value).is(":radio") || $(value).is(":checkbox")) {
				var b = val === "" ? "" : $(value).attr('checked', 'checked').val(val);
			}
			else {
				$(value).replaceWith(val);
			}

		});

	}



}