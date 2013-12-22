<?php
/**
*@package pXP
*@file gen-Atributo.php
*@author  (admin)
*@date 16-12-2013 18:42:43
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Atributo=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		
		Phx.vista.Atributo.superclass.constructor.call(this,config);
		this.init();
		this.bloquearMenus();		
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_atributo'
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
				name: 'nombre',
				fieldLabel: 'Nombre',
				gwidth: 100				
			},
				type:'Field',
				filters:{pfiltro:'planat.nombre',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'descripcion',
				fieldLabel: 'Descripcion',
				gwidth: 100
			},
				type:'Field',
				filters:{pfiltro:'planat.descripcion',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'valor',
				fieldLabel: 'Valor',
				allowBlank: false,
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'atri.valor',type:'string'},
				id_grupo:1,
				grid:true,
				form:false,
				egrid:true
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
				filters:{pfiltro:'planat.estado_reg',type:'string'},
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
				filters:{pfiltro:'planat.fecha_reg',type:'date'},
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
				filters:{pfiltro:'planat.fecha_mod',type:'date'},
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
	title:'Atributo',
	ActSave:'../../sis_netman/control/Atributo/insertarAtributo',
	ActList:'../../sis_netman/control/Atributo/listarAtributo',
	id_store:'id_plantilla_atributo',
	fields: [
		{name:'id_atributo', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'descripcion', type: 'string'},
		{name:'id_entidad', type: 'numeric'},
		{name:'nombre', type: 'string'},
		{name:'valor', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_atributo',
		direction: 'ASC'
	},
	bdel:false,
	bnew:false,
	bedit:false,
	bsave:true,
	onReloadPage:function(m){    	 
       this.maestro=m;
       this.load({params:{start:0, limit:this.tam_pag,id_entidad: this.maestro.id_entidad}});    	
    }
	}
)
</script>		