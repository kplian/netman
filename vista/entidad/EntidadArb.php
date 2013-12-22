<?php
/**
*@package pXP
*@file gen-UniCons.php
*@author  (rac)
*@date 09-08-2012 00:42:57
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.EntidadArb=Ext.extend(Phx.arbInterfaz,{

	constructor:function(config){
		Phx.vista.EntidadArb.superclass.constructor.call(this,config);
    	this.init();		
		this.root.setText('Infraestructura de Red');
		this.root.setIcon('../../../sis_netman/vista/entidad/network.png');		  						
	},
	enableDD:false,
	expanded:false,
	rootVisible:true,
	rootExpandable:false,
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_estructura_entidad'
			},
			type:'Field',
			form:true 
		},{
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
					name: 'id_entidad_padre'
			},
			type:'Field',
			form:true 
		},
		
		{
	       			config:{
	       				 typeAhead: false,
	       				  hideTrigger:false,
	       				  forceSelection:true,
	       				  name:'id_plantilla_entidad',
	       				  fieldLabel:'Plantilla para Añadir',
	       				  allowBlank:false,
	       				  emptyText:'Plantilla',
	       				  store: new Ext.data.JsonStore({

	    					url: '../../sis_netman/control/PlantillaEntidad/listarPlantillaEntidadCmb',
	    					id: 'id_plantilla_entidad',
	    					root: 'datos',
	    					sortInfo:{
	    						field: 'nombre',
	    						direction: 'ASC'
	    					},
	    					totalProperty: 'total',
	    					fields: ['id_plantilla_entidad','marca','modelo','nombre','descripcion','tipo_entidad'],
	    					// turn on remote sorting
	    					remoteSort: true,
	    					baseParams:{par_filtro:'nombre#descripcion#marca#modelo'}
	    				}),
	    				//rawValueField:'nombre_tipo_equipo',//campo adicional utilizado para utilizar el combo como insercion
	    				hiddenName: 'id_plantilla_entidad',
	    			    valueField: 'id_plantilla_entidad',
	       				displayField: 'nombre',
	       				gdisplayField: 'nombre',
	       				//typeAhead: true,
	           			triggerAction: 'all',
	           			lazyRender:true,
	       				mode:'remote',
	       				pageSize:10,
	       				queryDelay:200,
	       				anchor:'90%',
	       				minChars:2,
		       			tpl:'<tpl for="."><div class="x-combo-list-item"><p><b>{tipo_entidad}</b></p><p>{nombre}</p><p>{marca}</p><p>{modelo}</p> </div></tpl>'
		   			},
	       			type:'ComboBox',
	       			id_grupo:1,
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
				id_grupo:1,
				form:true
		},
	],
	//colocan e combo al inicio de la barra de herramientas
   
	title:'Entidad',
	ActSave:'../../sis_netman/control/Entidad/insertarEntidadArb',
	ActDel:'../../sis_netman/control/Entidad/eliminarEntidadArb',
	ActList:'../../sis_netman/control/Entidad/listarEntidadArb',
	fheight:'45%',
	fwidth:'40%',
	id_nodo:'id_entidad',
	id_nodo_p:'id_entidad_padre',
	
	fields: ['id',//identificador unico del nodo (concatena identificador de tabla con el tipo de nodo)
		      //porque en distintas tablas pueden exitir idetificadores iguales
		      
		{name:'id_plantilla_entidad', type: 'numeric'},
		{name:'id_plantilla_padre', type: 'numeric'},
		{name:'tipo_entidad', type: 'string'},
		{name:'nombre', type: 'string'},
		{name:'descripcion', type: 'string'},
		{name:'eliminable', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date', dateFormat:'Y-m-d H:i:s'},
		{name:'fecha_mod', type: 'date', dateFormat:'Y-m-d H:i:s'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'}
	],
	sortInfo:{
		field: 'id_plantilla_entidad',
		direction: 'ASC'
	},
	bdel:true,
	bnew:true,
	bedit:false,
	onButtonDel : function () {
		var nodo = this.sm.getSelectedNode();
		if (nodo.attributes['eliminable'] == 'si') {
			if (confirm('¿Esta seguro de eliminar el nodo y todas sus dependencias?')) {
				Phx.CP.loadingShow();
				
				var params = {};
				params['id_estructura_entidad'] = nodo.attributes['id_estructura_entidad'];
				
				Ext.Ajax.request({
					url : this.ActDel,
					success : this.successDel,
					failure : this.conexionFailure,
					params : params,
					argument : {
						'nodo' : this.sm.getSelectedNode().parentNode
					},
					timeout : this.timeout,
					scope : this
				});
				this.sm.clearSelections()
			}
		} else {
			alert('No es posible eliminar esta entidad, intente con el nivel superior');
		}
		
	},
	east:{
		  url:'../../../sis_netman/vista/entidad/Entidad.php',
		  title:'Detalle Entidad', 
		  width:'60%',
		  cls:'Entidad'
	}	
})
</script>
		
		