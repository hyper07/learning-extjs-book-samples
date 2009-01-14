var xmltree = new Ext.tree.TreePanel({el: 'treeContainer'});
var proxy = new Ext.data.HttpProxy({url: 'http://localhost/treexml.php'});
proxy.load(null, {
	read: function(xmlDocument) {
		//parseXmlAndCreateNodes(xmlDocument);
	}
}, function(){ xmltree.render(); });