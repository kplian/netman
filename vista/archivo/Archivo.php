<?php
/**
*@package pXP
*@file gen-Archivo.php
*@author  (admin)
*@date 17-12-2013 17:20:07
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Archivo=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Archivo.superclass.constructor.call(this,config);
		this.init();
		
		this.load({params:{start:0, limit:this.tam_pag,id_plantilla_entidad: this.id_plantilla_entidad,id_entidad: this.id_entidad}});
		this.addButton('btnUpload', {
                text : 'Subir Archivo',
                iconCls : 'bupload1',
                disabled : true,
                handler : SubirArchivo,
                tooltip : '<b>Cargar Documento</b><br/>Al subir el archivo, el registro sera marcado como Chequeado OK'
        });
        
        function SubirArchivo()
        {                   
            var rec=this.sm.getSelected();
            Phx.CP.loadWindows('../../../sis_netman/vista/archivo/SubirArchivo.php',
            'Subir Archivo',
            {
                modal:true,
                width:450,
                height:150
            },rec.data,this.idContenedor,'SubirArchivo')
        }
        if (this.id_entidad == '' || this.id_entidad == undefined) {
        	this.Atributos[1].valorInicial = this.id_plantilla_entidad;
        }
        
        this.Atributos[2].valorInicial = this.id_entidad;
          
        
    },
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_archivo'
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
					name: 'id_entidad'
			},
			type:'Field',
			form:true 
		},
		
		{
            config:{
                name: 'chequeado',
                fieldLabel: 'Chequeado',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                renderer:function (value, p, record){  
                            if(record.data['extension'] != '')
                            	return  String.format('{0}',"<div style='text-align:center'><img src = '../../../lib/imagenes/icono_dibu/dibu_ok.png' align='center' width='45' height='45'/></div>");
                            else
                            	return  String.format('{0}',"<div style='text-align:center'><img src = '../../../lib/imagenes/icono_dibu/dibu_eli.png' align='center' width='45' height='45'/></div>");
                        },
            },
            type:'Checkbox',
            id_grupo:1,
            grid:true,
            form:false
        },
		       
        
		{
			config:{
				name: 'nombre_doc',
				fieldLabel: 'Nombre Archivo',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:200
			},
				type:'TextField',
				filters:{pfiltro:'archi.nombre_doc',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'extension',
				fieldLabel: 'Extension',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:15
			},
				type:'TextField',
				filters:{pfiltro:'archi.extension',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		
		{
            config:{
                fieldLabel: "Enlace",
                gwidth: 130,
                inputType:'file',
                name: 'archivo',
                buttonText: '',   
                maxLength:150,
                anchor:'100%',
                renderer:function (value, p, record){  
                            if(record.data['extension'].length!=0) {
                            	var data = "id=" + record.data['id_archivo'];
                            	data += "&extension=" + record.data['extension'];
                            	data += "&sistema=sis_netman";
                            	data += "&clase=Archivo";
                            	return  String.format('{0}',"<div style='text-align:center'><a target=_blank href = '../../../lib/lib_control/CTOpenFile.php?"+ data+"' align='center' width='70' height='70'>Abrir documento</a></div>");
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
				name: 'estado_reg',
				fieldLabel: 'Estado Reg.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
				type:'TextField',
				filters:{pfiltro:'archi.estado_reg',type:'string'},
				id_grupo:1,
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
				filters:{pfiltro:'archi.fecha_reg',type:'date'},
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
				filters:{pfiltro:'archi.fecha_mod',type:'date'},
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
	title:'Documentos',
	ActSave:'../../sis_netman/control/Archivo/insertarArchivo',
	ActDel:'../../sis_netman/control/Archivo/eliminarArchivo',
	ActList:'../../sis_netman/control/Archivo/listarArchivo',
	id_store:'id_archivo',
	fields: [
		{name:'id_archivo', type: 'numeric'},
		{name:'id_entidad', type: 'numeric'},
		{name:'id_plantilla_entidad', type: 'numeric'},
		{name:'extension', type: 'string'},
		{name:'nombre_doc', type: 'string'},
		{name:'nombre_arch_doc', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_archivo',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
	preparaMenu:function(tb){
        Phx.vista.Archivo.superclass.preparaMenu.call(this,tb)
        this.getBoton('btnUpload').enable();
    },
    
    liberaMenu:function(tb){
        Phx.vista.Archivo.superclass.liberaMenu.call(this,tb)
        this.getBoton('btnUpload').disable();      
    }
	}
)
</script>
		
		