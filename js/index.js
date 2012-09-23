// JavaScript Document

var GeneralClass = new Class({
	trace: function(text) {
		$('trace').appendText(text + "\n", 'top');
	}
});
var general = new GeneralClass();

var action = "";

var galleryRequest = new Request({
	url: 'remotes/gallery.remote.php',
	evalScripts: true
});
var GalleryClass = new Class({
	initialize: function() {
		this.images = new Array();
		this.time = 0;
		this.currentImage = -1;
		$('gal1').fade('hide');
	},
	loadData: function() {
		galleryRequest.send("action=getdata");
		galleryRequest.send("action=gettime");
	},
	saveData: function(t, a) {
		this.time = t;
		this.imageCount = a.length;
		$('loader').setStyle('width', 0);
		$('loaderBox').setStyle('display', 'block');
		this.images = new Asset.images(a, {
			onProgress: function(c) {
				w = (200 / gallery.imageCount) * c;
				$('loader').setStyle('width', w);
			},
			onComplete: function() {
				$('loaderBox').setStyle('display', 'none');
				gallery.switchImage();
			}
		});
	},
	switchImage: function() {
		this.currentImage++;
		if($defined(this.images[this.currentImage])) {
			galleryRequest.send("action=setprogress&count="+this.currentImage);
			frame = this.currentImage % 2;
			file = this.images[this.currentImage].get('src');
			if(frame == 1) {
				$('gal1').setStyle('background-image', 'url(' + file + ')');
				$('gal1').fade('in');
			} else {
				$('gal0').setStyle('background-image', 'url(' + file + ')');
				$('gal1').fade('out');
			}
			this.delayLoader = this.switchImage.bind(this).delay(this.time * 1000);
		} else {
			galleryRequest.send("action=forceschwarz");
		}
	},
	unload: function() {
		galleryRequest.send("action=setprogress&count=reset");
		$clear(gallery.delayLoader);
		$('gal0').setStyle('background-image', 'none');
		$('gal1').setStyle('background-image', 'none').fade('hide');
		this.currentImage = -1;
	}
});
var gallery = new GalleryClass();

var sponsorsRequest = new Request({
	url: 'remotes/sponsors.remote.php',
	evalScripts: true
});
var SponsorsClass = new Class({
	id: 0,
	loadData: function() {
		sponsorsRequest.send("action=loaddata&id=" + this.id);
	},
	showFile: function(file, time, sortid) {
		this.id = sortid;
		$('sponsor').setStyle('background-image', 'url(' + file + ')');
		this.delayLoader = this.loadData.bind(this).delay(time * 60000);
	},
	unload: function() {
		$clear(this.delayLoader);
		$('sponsor').setStyle('background-image', 'none');
		this.id = 0;
	}
});
var sponsors = new SponsorsClass();
var specialsRequest = new Request({
	url: 'remotes/specials.remote.php',
	initialDelay: 500,
	delay: 500,
	limit: 500,
	evalScripts: true
});
var SpecialsClass = new Class({
	file: '',
	loadFile: function() {
		specialsRequest.send("action=getfile");
	},
	unloadFile: function() {
		$('special').setStyle('background-image', 'none');	
	},
	showFile: function(file) {
		this.file = file;
		$('special').setStyle('background-image', 'url(' + file + ')');
	}
});
var specials = new SpecialsClass();

var changeAction = function(newAction) {
	
	if(action != "")
		$(action).setStyle('display', 'none');
	$(newAction).setStyle('display', 'block');
	
	switch(newAction) {
		case "sponsor":
			sponsors.loadData();
			break;
		case "galerie":
			gallery.loadData();
			break;
		case "special":
			specials.loadFile();
			specialsRequest.startTimer('action=getfile');
			break;
	}
	
	switch(action) {
		case "sponsor":
			sponsors.unload();
			break;
		case "galerie":
			gallery.unload();
			break;
		case "special":
			specials.unloadFile();
			specialsRequest.stopTimer();
			break;
	}
	
	action = newAction;
	
}

var actionRequest = new Request({
	url: 'remotes/general.remote.php',
	onSuccess: function(text) {
		if(text != action)
			changeAction(text);
	},
	initialDelay: 0,
	delay: 500,
	limit: 500
});
actionRequest.startTimer('action=get');

var ClockClass = new Class({
	initialize: function() {
		this.toggle('hide');
		this.status = "";
		this.period = "";
	},
	toggle: function(state) {
		$('clock').fade(state);
		this.status = state;
		if(state == "in") {
			this.update();
			this.period = this.update.periodical(5000);
		} else
			$clear(this.period);
	},
	update: function() {
		$('clock').set('html', new Date().format('%H:%M'));
	}
});
var clock = new ClockClass();
var clockRequest = new Request({
	url: 'remotes/clock.remote.php',
	onSuccess: function(text) {
		if(text != clock.status) {
			clock.toggle(text);
		}
	},
	initialDelay: 0,
	delay: 500,
	limit: 500
});
clockRequest.startTimer('action=get');

var TickerClass = new Class({
	initialize: function() {
		this.status = "";
		this.toggle('hide');
	},
	toggle: function(state) {
		$('ticker').fade(state);
		if(state == 'in')
			$('clock').setStyle('background-color', 'rgba(0,0,0,.8)');
		else
			$('clock').setStyle('background-color', 'rgba(0,0,0,.5)');
	}
});
var ticker = new TickerClass();
var tickerRequest = new Request({
	url: 'remotes/ticker.remote.php',
	onSuccess: function(a) {
		a = a.split("-=-");
		state = a[0];
		text = a[1];
		if(ticker.status != state)
			ticker.toggle(state);
		$('ticker').set('html', text);
	},
	initialDelay: 0,
	delay: 500,
	limit: 500
});
tickerRequest.startTimer('action=get');