<?php
/**
*@package pXP
*@file gen-Entidad.php
*@author  (admin)
*@date 16-12-2013 17:20:55
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Entidad=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Entidad.superclass.constructor.call(this,config);
		this.init();
				        
        this.addButton('btnArchivos',
            {
                text: 'Archivos',
                iconCls: 'bchecklist',
                disabled: true,
                handler: this.loadArchivos,
                tooltip: '<b>Archivos de la plantilla</b><br/>Manuales, imagenes o archivos relacionados.'
            }
        );
        
        this.addButton('btnRelacion',
            {
                text: 'Conectar',
                icon: '../../../lib/imagenes/connect.png',
                disabled: true,
                handler: this.onButtonEdit,
                tooltip: '<b>Conectar con otro puerto</b><br/>Relacionar este puerto con otro en otro equipo.'
            }
        );
        
        this.addButton('btnDesconectar',
            {
                text: 'Desconectar',
                icon: '../../../lib/imagenes/disconnect.png',
                disabled: true,
                handler: this.onBtnDesconectar,
                tooltip: '<b>Desconectar el puerto</b><br/>Desconectar este puerto del otro equipo.'
            }
        );
        this.bloquearMenus();	
        this.iniciarEventos();
        
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_entidad'
			},
			type:'Field',
			form:true 
		},
		
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_plantilla_entidad'
			},
			type:'Field',
			form:true 
		},
		
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'desconectar'
			},
			type:'Field',
			form:true 
		},
			
		{
			config:{
				name: 'tipo_entidad',
				fieldLabel: 'Tipo Entidad',
				gwidth: 100
			},
				type:'Field',
				filters:{	
	       		         pfiltro:'plaen.tipo_entidad',
                		 type:'string'	
	       		 	},
				id_grupo:1,
				grid:true,
				form:false
		},
		
		{
			config:{
				name: 'nombre',
				fieldLabel: 'Nombre',
				gwidth: 100,
				maxLength:100
			},
				type:'Field',
				filters:{	
	       		         pfiltro:'en.nombre',
                		 type:'string'	
	       		 	},
				id_grupo:1,
				grid:true,
				form:false,
				egrid:true
				
		},
		
		{
			config:{
				name: 'codigo',
				fieldLabel: 'Codigo',
				gwidth: 80,
				maxLength:20
			},
				type:'TextField',
				filters:{	
	       		         pfiltro:'en.codigo',
                		 type:'string'	
	       		 	},
				id_grupo:1,
				grid:true,
				form:false,
				egrid:true
				
		},
		
		{
			config:{
				name: 'codigo_af',
				fieldLabel: 'Codigo AF',
				gwidth: 80,
				maxLength:20
			},
				type:'TextField',
				filters:{	
	       		         pfiltro:'en.codigo_af',
                		 type:'string'	
	       		 	},
				id_grupo:1,
				grid:true,
				form:false,
				egrid:true
				
		},
		
		{
			config:{
				name: 'observaciones',
				fieldLabel: 'Observaciones',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				
			},
				type:'TextArea',
				filters:{pfiltro:'en.observaciones',type:'string'},
				id_grupo:1,
				grid:true,
				form:false,
				egrid:true
		},
		
		{
			config:{
				name: 'marca',
				fieldLabel: 'Marca',
				gwidth: 100
			},
				type:'Field',
				filters:{	
	       		         pfiltro:'plaen.marca',
                		 type:'string'	
	       		 	},
				id_grupo:1,
				grid:true,
				form:false
		},
		
		{
			config:{
				name: 'modelo',
				fieldLabel: 'Modelo',
				gwidth: 100
			},
				type:'Field',
				filters:{	
	       		         pfiltro:'plaen.modelo',
                		 type:'string'	
	       		 	},
				id_grupo:1,
				grid:true,
				form:false
		},
		
		{
			config:{
				name: 'descripcion',
				fieldLabel: 'Descripción',
				gwidth: 150
			},
				type:'Field',
				filters:{	
	       		         pfiltro:'plaen.descripcion',
                		 type:'string'	
	       		 	},
				id_grupo:1,
				grid:true,
				form:false
		},
		
		{
	       			config:{
	       				 typeAhead: false,
	       				  hideTrigger:false,
	       				  forceSelection:true,
	       				  name:'id_entidad_equipo',
	       				  fieldLabel:'Equipo a relacionar',
	       				  allowBlank:false,
	       				  emptyText:'Seleccione el Equipo',
	       				  store: new Ext.data.JsonStore({

	    					url: '../../sis_netman/control/Entidad/listarEntidad',
	    					id: 'id_entidad',
	    					root: 'datos',
	    					sortInfo:{
	    						field: 'en.nombre',
	    						direction: 'ASC'
	    					},
	    					totalProperty: 'total',
	    					fields: ['id_entidad','codigo','marca','modelo','nombre','descripcion','tipo_entidad'],
	    					// turn on remote sorting
	    					remoteSort: true,
	    					baseParams:{par_filtro:'en.nombre#plaen.descripcion#plaen.marca#plaen.modelo#en.codigo', tipo_entidad:'equipment'}
	    				}),
	    				//rawValueField:'nombre_tipo_equipo',//campo adicional utilizado para utilizar el combo como insercion
	    				hiddenName: 'id_entidad_equipo',
	    			    valueField: 'id_entidad',
	       				displayField: 'nombre',
	       				gdisplayField: 'desc_equipo_relacion',
	       				//typeAhead: true,
	           			triggerAction: 'all',
	           			lazyRender:true,
	       				mode:'remote',
	       				pageSize:10,
	       				queryDelay:200,
	       				anchor:'90%',
	       				minChars:2,
		       			tpl:'<tpl for="."><div class="x-combo-list-item"><p><b>{tipo_entidad}</b></p><p>{nombre}</p><p>{marca}-{modelo}</p><p><b>{codigo}</b></p> </div></tpl>'
		   			},
	       			type:'ComboBox',
	       			id_grupo:1,
	       			form:true,
	       			grid:false
	       	},
	       	
	       	{
	       			config:{
	       				 typeAhead: false,
	       				  hideTrigger:false,
	       				  forceSelection:true,
	       				  name:'id_entidad_relacion',
	       				  fieldLabel:'Puerto',
	       				  allowBlank:false,
	       				  emptyText:'Seleccione el Puerto',
	       				  store: new Ext.data.JsonStore({

	    					url: '../../sis_netman/control/Entidad/listarEntidad',
	    					id: 'id_entidad',
	    					root: 'datos',
	    					sortInfo:{
	    						field: 'en.nombre',
	    						direction: 'ASC'
	    					},
	    					totalProperty: 'total',
	    					fields: ['id_entidad','codigo','marca','modelo','nombre','descripcion','tipo_entidad'],
	    					// turn on remote sorting
	    					remoteSort: true,
	    					baseParams:{par_filtro:'en.nombre#plaen.descripcion#plaen.marca#plaen.modelo#en.codigo', tipo_entidad:'port'}
	    				}),
	    				//rawValueField:'nombre_tipo_equipo',//campo adicional utilizado para utilizar el combo como insercion
	    				hiddenName: 'id_entidad_relacion',
	    			    valueField: 'id_entidad',
	       				displayField: 'nombre',
	       				gdisplayField: 'desc_entidad_relacion',
	       				//typeAhead: true,
	           			triggerAction: 'all',
	           			lazyRender:true,
	       				mode:'remote',
	       				pageSize:10,
	       				queryDelay:200,
	       				anchor:'90%',
	       				minChars:2,
	       				gwidth: 210,
		       			tpl:'<tpl for="."><div class="x-combo-list-item"><p><b>{tipo_entidad}</b></p><p>{nombre}</p><p>{marca}-{modelo}</p><p><b>{codigo}</b></p> </div></tpl>'
		   			},
	       			type:'ComboBox',
	       			id_grupo:1,
	       			form:true,
	       			grid:true
	       	},
		
		{
			config:{
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'plaen.fecha_reg',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usr_reg',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'NumberField',
				filters:{pfiltro:'usu1.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'fecha_mod',
				fieldLabel: 'Fecha Modif.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'plaen.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usr_mod',
				fieldLabel: 'Modificado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'NumberField',
				filters:{pfiltro:'usu2.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Detalle Entidad',
	ActSave:'../../sis_netman/control/Entidad/insertarEntidad',
	bnew:false,
	bedit:false,
	bdel:false,
	ActList:'../../sis_netman/control/Entidad/listarEntidad',
	id_store:'id_entidad',
	fields: [
		{name:'id_entidad', type: 'numeric'},
		{name:'id_plantilla_entidad', type: 'numeric'},
		{name:'id_entidad_relacion', type: 'numeric'},
		{name:'id_entidad_equipo', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'estado', type: 'string'},
		{name:'tipo_entidad', type: 'string'},
		{name:'desc_entidad_relacion', type: 'string'},
		{name:'nombre', type: 'string'},
		{name:'modelo', type: 'string'},
		{name:'marca', type: 'string'},
		{name:'codigo', type: 'string'},
		{name:'codigo_af', type: 'string'},
		{name:'observaciones', type: 'string'},
		{name:'descripcion', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_entidad',
		direction: 'ASC'
	},
	bsave:true,
	iniciarEventos : function () {
		this.Cmp.id_entidad_equipo.on('select',function(rec){ 
        	this.Cmp.id_entidad_relacion.store.baseParams.id_entidad_equipo=this.Cmp.id_entidad_equipo.getValue();
        	var data = this.getSelectedData();
        	this.Cmp.id_entidad_relacion.store.baseParams.id_entidad_negar = data.id_entidad;
        	this.Cmp.id_entidad_relacion.reset();
        	this.Cmp.id_entidad_relacion.modificado = true;
        	this.Cmp.id_entidad_relacion.enable();          
        },this);
	},
	onButtonEdit : function () {
		Phx.vista.Entidad.superclass.onButtonEdit.call(this);
		this.Cmp.id_entidad_equipo.modificado = true; 
		this.Cmp.id_entidad_relacion.modificado = true;
		this.Cmp.id_entidad_equipo.allowBlank = false; 
		this.Cmp.id_entidad_relacion.allowBlank = false;
        this.Cmp.id_entidad_relacion.disable();        
	},
	preparaMenu:function(tb){
        Phx.vista.Entidad.superclass.preparaMenu.call(this,tb);
        var data = this.getSelectedData();
        
        if (data.tipo_entidad == 'port' && (data.id_entidad_relacion == '' || data.id_entidad_relacion == undefined)) {
        	
        	this.getBoton('btnRelacion').enable();
        	this.getBoton('btnDesconectar').disable();
        } else if (data.tipo_entidad == 'port' && data.id_entidad_relacion != '') {
        	this.getBoton('btnRelacion').disable();
        	this.getBoton('btnDesconectar').enable();
        }  else {
        	this.getBoton('btnRelacion').disable();
        	this.getBoton('btnDesconectar').disable();
        }     
        this.getBoton('btnArchivos').enable();
        this.tbar.items.get('b-save-' + this.idContenedor).enable();       
        
    },
    loadArchivos:function() {
            var rec=this.sm.getSelected();
            rec.data.nombreVista = this.nombreVista;
            Phx.CP.loadWindows('../../../sis_netman/vista/archivo/Archivo.php',
                    'Archivos de plantilla',
                    {
                        width:700,
                        height:450
                    },
                    rec.data,
                    this.idContenedor,
                    'Archivo'
        )
    },    
    
    liberaMenu:function(tb){
        Phx.vista.Entidad.superclass.liberaMenu.call(this,tb);
        this.getBoton('btnArchivos').disable();
        this.getBoton('btnRelacion').disable();
        this.getBoton('btnDesconectar').disable();
        this.tbar.items.get('b-save-' + this.idContenedor).disable();              
    },
    onReloadPage:function(m){
    	this.getBoton('btnArchivos').disable(); 
       this.maestro=m;
       this.tbar.items.get('b-save-' + this.idContenedor).disable(); 
       
       if (this.maestro.id_entidad != undefined && this.maestro.id_entidad != '') {
       		this.store.baseParams={id_entidad:this.maestro.id_entidad};
       		this.load({params:{start:0, limit:50}});
       } else {
       		this.bloquearMenus();
       }
    	
    },
    onBtnDesconectar:function() {     
    	    this.Cmp.id_entidad_equipo.allowBlank = true; 
		this.Cmp.id_entidad_relacion.allowBlank = true;
            this.loadForm(this.sm.getSelected());
            this.Componentes[2].setValue('si');
            this.onSubmit({
                    'news': false
                });
            
    },
	south:{
		  url:'../../../sis_netman/vista/atributo/Atributo.php',
		  title:'Atributos', 
		  height:300,
		  cls:'Atributo'
	}
	}
)
</script>
		
		