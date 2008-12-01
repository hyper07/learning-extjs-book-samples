<html>
<head>
    <title>Basic Layout</title>
    <link rel="stylesheet" type="text/css" href="../lib/extjs/resources/css/ext-all.css" />
 	<script type="text/javascript" src="../lib/extjs/adapter/ext/ext-base.js"></script>
    <script type="text/javascript" src="../lib/extjs/ext-all.js"></script>
	<script>
	Ext.onReady(function(){
		Ext.BLANK_IMAGE_URL = 'images/s.gif';
		Ext.QuickTips.init();
		
		var viewport = new Ext.Viewport({
			layout: "border",
			renderTo: Ext.getBody(),
			items: [{
				region: "north",
				xtype: 'panel',
				html: 'North'
			},{
				region: 'west',
				xtype: 'panel',
				split: true,
				collapsible: true,
				collapseMode: 'mini',
				title: 'Some Info',
				bodyStyle:'padding:5px;',
				width: 200,
				minSize: 200,
				html: 'West'
			},{
				region: 'center',
				xtype: 'panel',
				html: 'Center'
			},{
				region: 'east',
				xtype: 'panel',
				split: true,
				width: 200,
				html: 'East'
			},{
				region: 'south',
				xtype: 'panel',
				html: 'South'
			}]
		}); 
		
	});
	</script>
</head>
<body>
</body>
</html>