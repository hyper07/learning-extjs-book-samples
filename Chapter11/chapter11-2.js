var lists = {

	today : null,
	tmrw : null,

	init : function() {
	
		this.today = new Ext.dd.DragZone('today');
		this.tmrw = new Ext.dd.DragZone('tmrw');
				
		var cfg = {
			//notifyDrop: function(){console.debug('nd', arguments);},
			onContainerDrop: function(){console.debug('oncd', arguments);},
			//onNodeDrop: function(){console.debug('onnd', arguments);},
			onDragDrop: function(){console.debug('ondd', arguments);}
		}

		new Ext.dd.DropZone('tmrw', cfg);
		new Ext.dd.DropZone('today', cfg);
				
		var drags = document.getElementsByTagName('li');

		for(var i =0; i< drags.length; i++){
			Ext.dd.Registry.register(drags[i]);
		}
	},
	
	drop : function(dropNodeData, source, event, dragNodeData) {

		var sourceContainer = source.el.dom;
		var dragged = source.dragData.ddel;
		var destinationContainer = this.getEl();
	
		sourceContainer.removeChild(dragged);
		destinationContainer.appendChild(dragged);

		return true;
	}
};

Ext.onReady(lists.init, lists);