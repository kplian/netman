<?php
/**
*@package pXP
*@file gen-PlantillaEntidad.php
*@author  (admin)
*@date 16-12-2013 17:20:55
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.PlantillaEntidad=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.PlantillaEntidad.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}});
		this.addButton('btnIcon', {
                text : 'Icono',
                iconCls : 'bupload1',
                disabled : true,
                handler : SubirArchivo,
                tooltip : '<b>Cargar Icono</b><br/>Icono relacionado a la plantilla'
        });
        
        this.addButton('btnArchivos',
            {
                text: 'Archivos',
                iconCls: 'bchecklist',
                disabled: true,
                handler: this.loadArchivos,
                tooltip: '<b>Archivos de la plantilla</b><br/>Manuales, imagenes o archivos relacionados.'
            }
        );
        
        this.addButton('btnAtributos',
            {
                text: 'Atributos',
                iconCls: 'bdocuments',
                disabled: true,
                handler: this.loadPlantillaAtributo,
                tooltip: '<b>Atributos de la entidad</b><br/>Configuracion de atributos de la entidad'
            }
        );
        
        this.addButton('btnBlock', {
				text : '',
				iconCls : 'block',
				disabled : true,
				handler : this.onBtnBlock,
				tooltip : '<b>Bloquear</b><br/>Bloquea la edición de la plantilla antes de empezar a usar'
			});
              
        
        function SubirArchivo()
        {                   
            var rec=this.sm.getSelected();
            
            Phx.CP.loadWindows('../../../sis_netman/vista/plantilla_entidad/SubirArchivo.php',
            'Subir Archivo',
            {
                modal:true,
                width:450,
                height:150
            },rec.data,this.idContenedor,'SubirArchivo')
        }
	},
			
	Atributos:[
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
					name: 'estado'
			},
			type:'Field',
			form:true 
		},
		
		
		{
			config:{
				name: 'tipo_entidad',
				fieldLabel: 'Tipo Entidad',
				allowBlank: false,
				emptyText:'Tipo...',
	       		typeAhead: true,
	       		triggerAction: 'all',
	       		lazyRender:true,
	       		mode: 'local',
				gwidth: 100,
				store:['campus','building','rack','equipment','port']
			},
				type:'ComboBox',
				filters:{	
	       		         type: 'list',
	       				 options: ['campus','building','rack','equipment','port'],	
	       		 	},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'nombre',
				fieldLabel: 'nombre',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:100
			},
				type:'TextField',
				filters:{pfiltro:'plaen.nombre',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'marca',
				fieldLabel: 'marca',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:80
			},
				type:'TextField',
				filters:{pfiltro:'plaen.marca',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'modelo',
				fieldLabel: 'modelo',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:80
			},
				type:'TextField',
				filters:{pfiltro:'plaen.modelo',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'descripcion',
				fieldLabel: 'descripcion',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				
			},
				type:'TextArea',
				filters:{pfiltro:'plaen.descripcion',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
            config:{
                fieldLabel: "Icono",
                gwidth: 130,
                inputType:'file',
                name: 'icono',
                buttonText: '',   
                maxLength:150,
                anchor:'100%',
                renderer:function (value, p, record){  
                            if(record.data['icono'].length!=0) {
                            	var data = "id=" +  record.data['id_plantilla_entidad'];
                            	data += "&extension=" + record.data['icono'];
                            	data += "&sistema=sis_netman";
                            	data += "&clase=PlantillaEntidad";
                            	return  String.format('{0}',"<div style='text-align:center'><a target=_blank href = '../../../lib/lib_control/CTOpenFile.php?"+ data+"' align='center' width='70' height='70'>Ver Icono</a></div>");
                            }
                        },  
                buttonCfg: {
                    iconCls: 'upload-icon'
                }
            },
            type:'Field',
            sortable:false,
            id_grupo:0,
            grid:true,
            form:false
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
	title:'Plantilla Entidad',
	ActSave:'../../sis_netman/control/PlantillaEntidad/insertarPlantillaEntidad',
	ActDel:'../../sis_netman/control/PlantillaEntidad/eliminarPlantillaEntidad',
	ActList:'../../sis_netman/control/PlantillaEntidad/listarPlantillaEntidad',
	id_store:'id_plantilla_entidad',
	fields: [
		{name:'id_plantilla_entidad', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'estado', type: 'string'},
		{name:'tipo_entidad', type: 'string'},
		{name:'nombre', type: 'string'},
		{name:'modelo', type: 'string'},
		{name:'marca', type: 'string'},
		{name:'icono', type: 'string'},
		{name:'descripcion', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_plantilla_entidad',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
	preparaMenu:function(tb){
        Phx.vista.PlantillaEntidad.superclass.preparaMenu.call(this,tb);
        var rec = this.sm.getSelected();
                
        this.getBoton('btnArchivos').enable();
        this.getBoton('btnAtributos').enable();
        if (rec.data.estado == 'closed') {
        	this.getBoton('btnIcon').disable();
        	this.getBoton('btnBlock').disable();
        	this.tbar.items.get('b-edit-' + this.idContenedor).disable();
        	this.tbar.items.get('b-del-' + this.idContenedor).disable();        	
        } else {
        	this.getBoton('btnBlock').enable();
        	this.getBoton('btnIcon').enable();
        }
        
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
    
    loadPlantillaAtributo:function() {
            var rec=this.sm.getSelected();
            rec.data.nombreVista = this.nombreVista;
            Phx.CP.loadWindows('../../../sis_netman/vista/plantilla_atributo/PlantillaAtributo.php',
                    'Atributos de Plantilla',
                    {
                        width:700,
                        height:450
                    },
                    rec.data,
                    this.idContenedor,
                    'PlantillaAtributo'
        )
    },
    
    onBtnBlock:function() {            
            this.loadForm(this.sm.getSelected());
            this.Componentes[1].setValue('closed');
            this.onSubmit({
                    'news': false
                });
    },
    
    liberaMenu:function(tb){
        Phx.vista.PlantillaEntidad.superclass.liberaMenu.call(this,tb);
        this.getBoton('btnIcon').disable(); 
        this.getBoton('btnArchivos').disable();
        this.getBoton('btnAtributos').disable();
        this.getBoton('btnBlock').disable();
             
    },
	east:{
		  url:'../../../sis_netman/vista/plantilla_entidad/PlantillaEntidadArb.php',
		  title:'Compuesto por', 
		  width:300,
		  cls:'PlantillaEntidadArb'
		 },
	}
)
</script>
		
		