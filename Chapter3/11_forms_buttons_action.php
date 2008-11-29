<html>
<head>
    <title>Forms Example</title>
    <link rel="stylesheet" type="text/css" href="../lib/extjs/resources/css/ext-all.css" />
 	<script type="text/javascript" src="../lib/extjs/adapter/ext/ext-base.js"></script>
    <script type="text/javascript" src="../lib/extjs/ext-all.js"></script>
	<script>
	Ext.onReady(function(){
		
		Ext.BLANK_IMAGE_URL = 'images/s.gif';
		Ext.QuickTips.init();
		Ext.form.VTypes["nameVal"]  = /^([A-Z]{1})[A-Za-z\-]+ ([A-Z]{1})[A-Za-z\-]+/;
		Ext.form.VTypes["nameMask"] = /[A-Za-z\- ]/;
		Ext.form.VTypes["nameText"] = 'In-valid Director Name.';
		Ext.form.VTypes["name"] 	= function(v){
			return Ext.form.VTypes["nameVal"].test(v);
		}
	    var genres = new Ext.data.SimpleStore({
	        fields: ['id', 'genre'],
	        data : [['0','New Genre'],['1','Comedy'],['2','Drama'],['3','Action']]
	    });
		var movie_form = new Ext.FormPanel({ 
			url: 'movie-form-submit.php',
			renderTo: document.body,
			frame: true,
			title: 'Movie Information Form',
			width: 250,
			items: [{
				xtype: 'textfield',
				fieldLabel: 'Title',
				name: 'title',
				allowBlank: false,
				listeners: {
					specialkey: function(f,e){
						if (e.getKey() == e.ENTER) {
							movie_form.getForm().submit();
						}
					}
				}
		    },{
				xtype: 'textfield',
				fieldLabel: 'Director',
				name: 'director',
				vtype: 'name'
		    },{
				xtype: 'datefield',
				fieldLabel: 'Released',
				name: 'released',
				disabledDays: [1,2,3,4,5]
		    },{
				xtype: 'radio',
				fieldLabel: 'Filmed In',
				name: 'filmed_in',
				boxLabel: 'Color'
			},{
				xtype: 'radio',
				hideLabel: false,
				labelSeparator: '',
				name: 'filmed_in',
				boxLabel: 'Black & White'
			},{
				xtype: 'checkbox',
				fieldLabel: 'Bad Movie',
				name: 'bad_movie'
			},{
				xtype: 'combo',
				name: 'genre',
				fieldLabel: 'Genre',
				mode: 'local',
				store: genres,
				displayField:'genre',
				width: 130,
				listeners: {
					select: function(f,r,i){
						if (i == 0){
							Ext.Msg.prompt('New Genre','Name',Ext.emptyFn);
						}
					}
				}
			},{
				xtype: 'textarea',
				name: 'description',
				hideLabel: true,
				labelSeparator: '',
				height: 100,
				anchor: '100%'
			}],
			buttons: [{
				text: 'Save',
				handler: function(){
                    movie_form.getForm().submit({
                        success: function(f,a){
                            Ext.Msg.alert('Success', 'It worked');
                        },
                        failure: function(f,a){
                            if (a.failureType === Ext.form.Action.CONNECT_FAILURE){
                                Ext.Msg.alert('Failure', 'Server reported:'+a.response.status+' '+a.response.statusText);
                            }
                            if (a.failureType === Ext.form.Action.SERVER_INVALID){
                                Ext.Msg.alert('Warning', a.result.errormsg);
                            }
                        }
                    });
				}
			}, {
				text: 'Reset',
				handler: function(){
					movie_form.getForm().reset();
				}
			}]
		});
	});
	</script>
</head>
<body>
</body>
</html>