// JavaScript Document

var galleryRequest = new Request({
	url: 'remotes/gallery.remote.php',
	evalScripts: true
});
var galleryRefreshTween = new Fx.Tween('galleryRefreshButton', { link: 'chain' });
var gallerySelectTween = new Fx.Tween('gallery', { link: 'chain' });

var GalleryClass = new Class({
	
	reload: function() {
		galleryRequest.send("action=reload");
	},
	change: function() {
		galleryRequest.send("action=change&value=" + $('gallery').value);
	},
	stepTime: function(value) {
		newTime = $('galleryTime').value.toInt() + value;
		if(newTime > 0) {
			galleryRequest.send("action=time&time=" + newTime);
		}
	},
	highlightRefresh: function() {
		galleryRefreshTween.start('color', '#7f7').start('color', '#77f');
	},
	highlightSelect: function(color) {
		gallerySelectTween.start('border-color', color).start('border-color', '#777');
	}
	
});
var gallery = new GalleryClass();