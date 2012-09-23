// JavaScript Document


var myTips = new Tips(['.tooltip'], {
	showDelay: 0,
	offset: {
		'x': 5,
		'y': 5
	}
});

var generalRequest = new Request({
	url: 'remotes/general.remote.php',
	link: 'chain',
	evalScripts: true
});

var modSortables = new Sortables('#col1, #col2', {
	clone: true,
	opacity: .5,
	revert: true,
	handle: 'legend',
	onComplete: function() {
		serial = modSortables.serialize(false, function(element, index){
			return element.getProperty('id').replace('mod_', '');
		}).join('-');
		generalRequest.send('action=sortmodules&order=' + serial);
	}
});

var actionMorphSchwarz = new Fx.Morph('action_schwarz', { link: 'cancel' });
var actionMorphGalerie = new Fx.Morph('action_galerie', { link: 'cancel' });
var actionMorphSponsor = new Fx.Morph('action_sponsor', { link: 'cancel' });
var actionMorphSpecial = new Fx.Morph('action_special', { link: 'cancel' });

var action = function(action) {
	
	generalRequest.send("action=changeaction&id=" + action);
	
}

var enableScroll = function() {
	$$('body').setStyle('overflow', 'auto');
	$('scrollToggler').set('html', 'Scrollen deaktivieren').set('href', 'javascript:disableScroll()');
}
var disableScroll = function() {
	$$('body').setStyle('overflow', 'hidden');
	$('scrollToggler').set('html', 'Scrollen aktivieren').set('href', 'javascript:enableScroll()');
}

var forceListener = new Request({
	url: 'remotes/general.remote.php',
	evalScripts: true,
	initialDelay: 500,
	delay: 500,
	limit: 500
}).startTimer('action=getforce');

var galleryProgressListener = new Request({
	url: 'remotes/gallery.remote.php',
	evalScripts: true,
	initialDelay: 500,
	delay: 500,
	limit: 500
}).startTimer('action=getprogress');

// CLOCK
var clockRequest = new Request({
	url: 'remotes/clock.remote.php',
	evalScripts: true
});
var clockMorph = new Fx.Morph('clockButton', { link: 'cancel' });

var ClockClass = new Class({
	initialize: function() {
		this.refresh();
	},
	toggle: function() {
		clockRequest.send("action=toggleactive");
	},
	refresh: function() {
		$('clock').set('html', new Date().format('%H:%M:%S'));
	}
});
var clock = new ClockClass();
var clockPeriod = clock.refresh.periodical(1000);


// KONAMI
$('shortcuts').fade('hide');
var ShortcutClass = new Class({
	show: function() {
		$("shortcuts").fade("in");
	},
	hide: function() {
		$("shortcuts").fade("out");
	}
});
var shortcuts = new ShortcutClass();

var keyboardShortcuts = new Keyboard({
	eventType: 'keydown', 
	events: { 
		'ctrl+alt+1': action.pass("schwarz"),
		'ctrl+alt+2': action.pass("galerie"),
		'ctrl+alt+3': action.pass("sponsor"),
		'ctrl+alt+4': action.pass("special"),
		
		'ctrl+alt+9': clock.toggle,
		'ctrl+alt+0': ticker.toggle,
		
		'ctrl+alt+r': function() { gallery.reload(); specials.reload(); },
		'ctrl+alt+t': function() { $('tickerNewText').focus() },
		
		'ctrl+down': ticker.fav,
		
		'ctrl+alt+up': function() { gallery.stepTime(1); },
		'ctrl+alt+down': function() { gallery.stepTime(-1); },
		'ctrl+alt+shift+up': function() { gallery.stepTime(10); },
		'ctrl+alt+shift+down': function() { gallery.stepTime(-10); }
	}
}).activate();


var KonamiClass = new Class({
	initialize: function() {
		this.code = "up|up|down|down|left|right|left|right|b|a|";
		this.entered = "";
		this.active = false;
		$('konami').fade('hide');
	},
	done: function() {
		
		this.entered = "";
		
		$('sidebar').setStyle('position', 'fixed');
		$('col1').setStyle('position', 'fixed');
		$('col2').setStyle('position', 'fixed');
		
		winSize = window.getSize();
		this.sidebarSize = $('sidebar').getCoordinates();
		this.col1Size = $('col1').getCoordinates();
		this.col2Size = $('col2').getCoordinates();
		
		new Fx.Tween('sidebar', {
			duration: 1500,
			transition: 'cubic:in'
		}).start('left', this.sidebarSize.width * -1);
		new Fx.Tween('col1', {
			duration: 1500,
			transition: 'cubic:in'
		}).start('top', winSize.y);
		new Fx.Tween('col2', {
			duration: 1500,
			transition: 'cubic:in',
			onComplete: function() {
				$('konami').fade('in');
				konami.active = true;
			}
		}).start('left', winSize.x);
	},
	fixPage: function() {
		
		this.entered = "";
		
		$('konami').fade('out');
		
		new Fx.Tween('sidebar', {
			duration: 1000,
			transition: 'cubic:out',
			onComplete: function(el) {
				el.setStyle('position', 'absolute');	
			}
		}).start('left', this.sidebarSize.left);
		new Fx.Tween('col1', {
			duration: 1000,
			transition: 'cubic:out',
			onComplete: function(el) {
				el.setStyle('position', 'absolute');
			}
		}).start('top', this.col1Size.top);
		new Fx.Tween('col2', {
			duration: 1000,
			transition: 'cubic:out',
			onComplete: function(el) {
				el.setStyle('position', 'absolute');
				konami.active = false;
			}
		}).start('left', this.col2Size.left);
	}
});
var konami = new KonamiClass();
window.addEvent('keydown', function(event) {
	if(konami.code.contains(event.key + "|")) {
		konami.entered += event.key + "|";
		
		if(konami.entered != konami.code.substr(0, konami.entered.length))
			konami.entered = "";
		
		if(konami.entered == konami.code && !konami.active) {
			konami.done();
		}
	} else {
		if(event.key == "esc" && konami.active)
			konami.fixPage();
	}
});