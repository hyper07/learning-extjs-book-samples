var fx = {
	fadeout : function() {
		Ext.get('block').fadeOut();
		Ext.get('inline').fadeOut();
	},
	
	fadein : function() {
		Ext.get('block').fadeIn();
		Ext.get('inline').fadeIn();
	},
	
	frame : function() {
		Ext.get('block').frame("ff0000", 3);
		Ext.get('inline').frame("ff0000", 3);
	},
	
	ghost : function() {
		Ext.get('block').ghost();
		Ext.get('inline').ghost('tr');
	},
	
	highlight : function() {
		Ext.get('block').highlight();
		Ext.get('inline').highlight();
	},
	
	puff : function() {
		Ext.get('block').puff();
		Ext.get('inline').puff();
	},
	
	scale : function() {
		Ext.get('block').scale(50, 50);
		Ext.get('inline').scale(300, 20);
	},

	slideout : function() {
		Ext.get('block').slideOut();
		Ext.get('inline').slideOut('tl');
	},
	
	slidein : function() {
		Ext.get('block').slideIn();
		Ext.get('inline').slideIn('tl');
	},
	
	switch : function() {
		Ext.get('block').switchOff();
		Ext.get('inline').switchOff();
	},
	
	shift : function() {
		Ext.get('block').shift({x: 5, y: 300, width: 300, height: 200});
		Ext.get('inline').shift({y: 500, width: 50, height: 10});
	},
	
	switchoffextendedduration : function() {
		Ext.get('block').switchOff({
			duration: 10
		});
	}
};