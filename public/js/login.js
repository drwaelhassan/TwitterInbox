function Login() {
	const self = this;

	this.baseUrl = document.getElementById('baseUrl').value,

	this.init = function() {
		this.bindEvent();
	},

	this.login = function() {
		window.location.assign(`${self.baseUrl}/toTwitter`)
	},

	this.bindEvent = function() {
		var events = {
			login: {
				value: document.getElementById('twLogin'),
				event: 'click'
			}
		};


		for(key in events) {
			if (events[key].value) {
				events[key].value.key = key;
				events[key].value.event = events[key].event;
				events[key].value.addEventListener(events[key].value.event, function() {
					self[this.key].call(this);
				});
			}
		}
	}

}

document.addEventListener("DOMContentLoaded", function() {
	var login = new Login();

	login.init();
})