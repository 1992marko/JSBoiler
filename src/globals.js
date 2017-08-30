export default class Globals {

	static init(options) {
		
		//Put here default settings
		Globals._settings = {};
		Globals._lastSearch = {};
		Globals.steps = {};
		
	}

	static get settings() {
		return Globals._settings;
	}

	static set settings(param) {
		Globals._settings = param;
		Globals.API = param.API;
	}

	static get translations() {
		return Globals._translations;
	}

	static set translations(param) {
		Globals._translations = param;
	}

	static get user() {
		return Globals._user;
	}

	static set user(param) {
		Globals._user = param;
	}

	static get lastSearch() {
		return Globals._lastSearch;
	}

	static set lastSearch(param) {
		Globals._lastSearch = param;
	}

}