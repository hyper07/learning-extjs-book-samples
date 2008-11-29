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
				showHelp : function(btn){
                    Movies.doLoad(btn.helpfile);
				},
                doLoad : function(file){
                    var helpbody = Ext.get('helpbody');
                    if (!helpbody) {
                        Ext.DomHelper.append(Ext.getBody(), {tag:'div',id:'helpbody'});
                    }
                    Ext.get('helpbody').load({
                        url: 'html/' + file + '.txt'
                    });
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
				xtype: 'tbspacer'
			}]
		});
	});
	</script>
</head>
<body>
</body>
</html>