var customerService = {
	
	sessionsGroup : null,
	agentsGroup : null,
	
init : function() {
	var s = Ext.select;
	var g = Ext.get;

	this.sessionsGroup = new Ext.WindowGroup();
	this.agentsGroup = new Ext.WindowGroup();
	
	s('#mySessions div').on('click', this.showSession, this);
	s('#agents div').on('click', this.showAgent, this);

	g('hideSessions').on('click', this.sessionsGroup.hideAll);
	g('hideAgents').on('click', this.agentsGroup.hideAll);
	g('tileAgents').on('click', this.tileAgents, this);
	g('tileSessions').on('click', this.tileSessions, this);
},
	
	tileAgents : function(e) {	
		this.sessionsGroup.hideAll();
		this.tile(this.agentsGroup);
	},
	
	tileSessions : function(e) {	
		this.agentsGroup.hideAll();
		this.tile(this.sessionsGroup);
	},
	
	tile : function(group) {
		var previousWin = null;
		group.each(function(win){
		
			if(previousWin) {
				if(win.getEl().getWidth() + previousWin.getEl().getRight() > Ext.getBody().getWidth()) {
					win.alignTo(document.body, 'tl-tl', [0, previousWin.getEl().getHeight()]);
				} else {
					win.alignTo(previousWin.getEl(), 'tl-tr');
				}
			} else {
				win.alignTo(document.body, 'tl-tl');
			}

			previousWin = win;
		});
	},
	
showSession : function(e){
	var target = e.getTarget('div', 5, true);
	var sessionId = target.dom.id + '-win';
	var win = this.sessionsGroup.get(sessionId);

	if(!win) {
		win = new Ext.Window({
			manager: this.sessionsGroup,
			id: sessionId,
			width: 200,
			height: 200,
			resizable: false,
			closable: false,
			title: target.down('h3').dom.innerHTML,
			html: target.down('.content').dom.innerHTML
		});
	}
	
	win.show();
	win.alignTo(target);
},
	
	showAgent : function(e) {
		var target = e.getTarget('div', 5, true);
		var agentId = target.dom.id + '-win';
		var win = this.agentsGroup.get(agentId);

		if(!win) {
			win = new Ext.Window({
				manager: this.agentsGroup,
				id: agentId,
				width: 300,
				height: 350,
				resizable: false,
				title: target.down('h3').dom.innerHTML,
				html: target.down('.content').dom.innerHTML
			});
			
		}
		
		win.show();
		win.alignTo(target);
	}
};

Ext.onReady(customerService.init, customerService);