Ext.onReady(function() {
	new Ext.dd.DragSource("drag");
	new Ext.dd.DropTarget("drop", {
		notifyDrop : function(source, event, data) {
			this.getEl().appendChild(source.getEl());
		}
	});

	new Ext.dd.DragSource("container", {
		onStartDrag: function(e) {
			this.proxy.update(this.el.down('h1').dom.innerHTML);
        }
	});
});

