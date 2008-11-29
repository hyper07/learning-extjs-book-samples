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
                doSearch : function(frm,evt){
					if (evt.getKey() == evt.ENTER) {
                        var helpbody = Ext.get('helpbody');
                        if (!helpbody) {
                            helpbody = Ext.get(Ext.DomHelper.append(Ext.getBody(), {tag:'div',id:'helpbody'}));
                        }
						helpbody.dom.innerHTML = frm.getValue();
					}
				},
                showWinHelp : function(btn){
                    var winhelp = Ext.getCmp('helpwin');
                    if (!winhelp){
                        new Ext.Window({
                            title: 'Help',
                            id: 'helpwin',
                            width: 300,
                            height: 300,
                            tbar: [{
                                text: 'Close',
                                handler: function(){
                                    Ext.getCmp('helpwin').close();
                                }
                            },{
                                text: 'Disable',
                                handler: function(t){
                                    t.disable();
                                }
                            }],
                            autoLoad: 'html/' + btn.helpfile + '.txt'
                        }).show();
                    }else{
                        winhelp.body.load('html/' + btn.helpfile + '.txt');
                        winhelp.show();
                    }
                },
                doLoad : function(file){
                    var helpbody = Ext.get('helpbody');
                    if (!helpbody) {
                        helpbody = Ext.get(Ext.DomHelper.append(Ext.getBody(), {tag:'div',id:'helpbody'}));
                    }
                    helpbody.load({
                        url: 'html/' + file + '.txt'
                    });
                }
			};
		}();
	    var genres = new Ext.data.SimpleStore({
	        fields: ['id', 'genre'],
	        data : [['1','Comedy'],['2','Drama'],['3','Action']]
	    });
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
                    text: 'Better',
                    checked: true,
                    group: 'quality'
                }, {
                    text: 'Good',
                    checked: false,
                    group: 'quality'
                }, {
                    text: 'Best',
                    checked: false,
                    group: 'quality'
                }]
			},{
				xtype: 'tbseparator'
			},{
				xtype: 'tbsplit',
				text: 'Help',
				menu: [{
					text: 'Genre',
					helpfile: 'genre',
					handler: Movies.showWinHelp
				},{
					text: 'Director',
					helpfile: 'director',
					handler: Movies.showWinHelp
				},{
					text: 'Title',
					helpfile: 'title',
					handler: Movies.showWinHelp
				}]
			},{
				xtype: 'tbseparator'
			},{
				xtype: 'tbtext',
				text: 'Genre:'
			},{
				xtype: 'tbspacer'
			},{
				xtype: 'combo',
				id: 'genre',
				name: 'genre',
				mode: 'local',
				store: genres,
				displayField:'genre',
				width: 70
			},{
				xtype: 'tbspacer'
			},{
				xtype: 'textfield',
				listeners: {
					specialkey: Movies.doSearch
				}
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