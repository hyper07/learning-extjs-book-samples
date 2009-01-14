Ext.onReady(function() {

	// Instantiate main tree classes
	var treeLoader = new Ext.tree.TreeLoader({
		dataUrl:'http://localhost/samplejson.php'
	});

	var rootNode = new Ext.tree.AsyncTreeNode({
		text: 'Root'
	});

	var tree = new Ext.tree.TreePanel({
		renderTo:'treecontainer',
		loader: treeLoader,
		root: rootNode,
		enableDD: true
		//, selModel: new Ext.tree.MultiSelectionModel()
	});
	
	
	// Create ancilliary instances
	var filter = new Ext.tree.TreeFilter(tree);
	var editor = new Ext.tree.TreeEditor(tree);
	var sorter = new Ext.tree.TreeSorter(tree, {
	    folderSort: true,
	    dir: 'asc',
		sortType: function(node) {
			return parseInt(node.id, 10);
		}
	});	
	
	
	// State handling
	Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
	
	var treeState = Ext.state.Manager.get("treestate");
	if (treeState) 
		tree.expandPath(treeState);
	
	tree.on('expandnode', function (x, y){ Ext.state.Manager.set("treestate", x.getPath());});
	
	
	// Context menu & setup
	var contextMenu = new Ext.menu.Menu({
		items: [
			{ text: 'Delete', handler: deleteHandler },
			{ text: 'Sort', handler: sortHandler },
			{ text: 'Filter', handler: filterHandler }
		]
	});
	tree.on('contextmenu', treeContextHandler);
	
	
	// Drag and drop handler example
	tree.on('beforemovenode', function(tree, node, oldParent, newParent, index) {
		/*
		Disabled as its just an example
		Ext.Ajax.request({
			url: 'nodemove.php',
			params: {
				nodeid: node.id,
				newparentid: newParent.id,
				oldparentid: oldParent.id,
				dropindex: index
			}
		});
		*/
	});
	
	
	// Editor handler example
	editor.on('beforecomplete', function(editor, newValue, originalValue) {
		/*
		Disabled as its just an example
		Ext.Ajax.request({
			url: 'saveedit.php',
			params: {
				nodeid: editor.editNode.id
				newvalue: newValue
			}
		});
		*/
	});
	

	// Other handler functions
	function treeContextHandler(node) {
		node.select();
		contextMenu.show(node.ui.getAnchor());
	}

	function filterHandler() {
		var node = tree.getSelectionModel().getSelectedNode();
		filter.filter('Bee', 'text', node);
	}
	
	function deleteHandler() {
		tree.getSelectionModel().getSelectedNode().remove();
	}

	function sortHandler() {
		tree.getSelectionModel().getSelectedNode().sort(
			function (leftNode, rightNode) {
				return (leftNode.text.toUpperCase() < rightNode.text.toUpperCase() ? 1 : -1);
			}
		);
	}

	function customSorter(leftNode, rightNode) {
		return (leftNode.text.toUpperCase() < rightNode.text.toUpperCase() ? 1 : -1);
	}
});

