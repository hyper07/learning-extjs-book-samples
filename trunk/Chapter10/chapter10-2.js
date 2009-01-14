var extras = {

	spot : null,

	init : function() {
		Ext.QuickTips.init();
		Ext.get('loadmaskMe').on('click', this.loadMaskBasic, this);
		Ext.get('storeMask').on('click', this.loadMaskStore, this);
		
		new Ext.ToolTip({
			target: 'storeMask',
			html: 'Click this to see a mask tied to a store.'
		});
		
		this.spot = new Ext.Spotlight({
			easing: 'easeOut',
			duration: .3
		});
		Ext.get('spotlight').on('click', this.toggleSpot, this);
	},
	
	loadMaskBasic : function(e) {
		var container = e.getTarget('#loadmaskMe');
		
		if(!container.mask) {
			container.mask = new Ext.LoadMask(container);
			container.masked = true;
			container.mask.show();
		} else {
			if(container.masked) {
				container.masked = false;
				container.mask.hide();
			} else {
				container.masked = true;
				container.mask.show();
			}
		}
	},

	loadMaskStore : function() {
		var store = new Ext.data.JsonStore({
			url: 'pausejson.php',
			root: 'images',
			fields: ['name', 'url', {name:'size', type: 'float'}, {name:'lastmod', type:'date'}]
		});
		var m = new Ext.LoadMask(Ext.get('loadmaskMe'), {store:store});

		store.load();
	},
	
	toggleSpot : function(e) {
		if(this.spot.active)
			this.spot.show(e.getTarget('#spotlight'));
		else
			this.spot.hide();
	}
};

Ext.onReady(extras.init, extras);