<html>
<head>
    <title>Toolbar Example</title>
    <link rel="stylesheet" type="text/css" href="../lib/extjs/resources/css/ext-all.css" />
 	<script type="text/javascript" src="../lib/extjs/adapter/ext/ext-base.js"></script>
    <script type="text/javascript" src="../lib/extjs/ext-all.js"></script>
	<script>
	Ext.onReady(function(){
		var Movies = function() {
			return {
				init : function(){
					Ext.DomHelper.append(document.body, {tag:'div',id:'helpbody'});
				},
				showHelp : function(btn){
					Ext.get('helpbody').load({url:'html/'+btn.helpfile+'.txt'});
				},
				doSearch : function(frm,evt){
					if (evt.getKey() == evt.ENTER) {
						Ext.get('helpbody').dom.innerHTML = frm.getValue();
					}
				}
			};
		}();
		var toolbar = new Ext.Toolbar({
			renderTo: document.body,
			items: [{
				xtype: 'tbspacer'
			},{
				xtype: 'tbbutton',
				text: 'Button',
				handler: function(btn){
					btn.disable();
				}
			},{
				xtype: 'tbfill'
			},{
				xtype: 'tbbutton',
				cls: 'x-btn-icon',
				icon: 'images/bomb.png'
			},{
				xtype: 'tbbutton',
				text: 'Menu Button',
				menu: [{
					text: 'Better'
				},{
					text: 'Good'
				},{
					text: 'Best'
				}]
			},{
				xtype: 'tbseparator'
			},{
				xtype: 'tbsplit',
				text: 'Help',
				menu: [{
					text: 'Genre',
					helpfile: 'genre',
					handler: Movies.showHelp
				},{
					text: 'Director',
					helpfile: 'director',
					handler: Movies.showHelp
				},{
					text: 'Title',
					helpfile: 'title',
					handler: Movies.showHelp
				}]
			},{
				xtype: 'tbseparator'
			},{
				xtype: 'textfield',
				listeners: {
					specialkey: Movies.doSearch
				}
			},{
				xtype: 'tbspacer'
			}]
		});
		Movies.init();
	});
	</script>
</head>
<body>
</body>
</html>