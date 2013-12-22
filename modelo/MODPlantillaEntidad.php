<?php
/**
*@package pXP
*@file gen-MODPlantillaEntidad.php
*@author  (admin)
*@date 16-12-2013 17:20:55
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODPlantillaEntidad extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarPlantillaEntidad(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='netman.ft_plantilla_entidad_sel';
		$this->transaccion='NM_PLAEN_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_plantilla_entidad','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('estado','varchar');
		$this->captura('tipo_entidad','varchar');
		$this->captura('nombre','varchar');
		$this->captura('modelo','varchar');
		$this->captura('marca','varchar');
		$this->captura('icono','varchar');
		$this->captura('descripcion','text');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}

	function listarPlantillaEntidadArb(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='netman.ft_plantilla_entidad_sel';
		$this->transaccion='NM_PLAENARB_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		$this->setCount(false);	
		
		$this->setParametro('id_plantilla_entidad','id_plantilla_entidad','integer');
				
		//Definicion de la lista del resultado del query
		$this->captura('id_estructura_plantilla','int4');
		$this->captura('id_plantilla_padre','int4');
		$this->captura('id_plantilla_entidad','int4');
		$this->captura('tipo_entidad','varchar');
		$this->captura('nombre','varchar');
		$this->captura('modelo','varchar');
		$this->captura('marca','varchar');
		$this->captura('icono','varchar');
		$this->captura('tipo_nodo','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarPlantillaEntidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='netman.ft_plantilla_entidad_ime';
		$this->transaccion='NM_PLAEN_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('tipo_entidad','tipo_entidad','varchar');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('modelo','modelo','varchar');
		$this->setParametro('marca','marca','varchar');
		$this->setParametro('icono','icono','varchar');
		$this->setParametro('descripcion','descripcion','text');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	
	function insertarPlantillaEntidadArb(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='netman.ft_plantilla_entidad_ime';
		$this->transaccion='NM_PLAENARB_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_plantilla_entidad','id_plantilla_entidad','integer');
		$this->setParametro('id_plantilla_padre','id_plantilla_padre','integer');
		$this->setParametro('descripcion','descripcion','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarPlantillaEntidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='netman.ft_plantilla_entidad_ime';
		$this->transaccion='NM_PLAEN_MOD';
		$this->tipo_procedimiento='IME';
		$this->setCount(false);	
				
		//Define los parametros para la funcion
		$this->setParametro('id_plantilla_entidad','id_plantilla_entidad','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('tipo_entidad','tipo_entidad','varchar');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('modelo','modelo','varchar');
		$this->setParametro('marca','marca','varchar');
		$this->setParametro('icono','icono','varchar');
		$this->setParametro('descripcion','descripcion','text');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarPlantillaEntidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='netman.ft_plantilla_entidad_ime';
		$this->transaccion='NM_PLAEN_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_plantilla_entidad','id_plantilla_entidad','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	
	function eliminarPlantillaEntidadArb(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='netman.ft_plantilla_entidad_ime';
		$this->transaccion='NM_PLAENARB_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_estructura_plantilla','id_estructura_plantilla','int4');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	
	function subirArchivo(){
        $this->procedimiento='netman.ft_plantilla_entidad_ime';
        
        $this->transaccion='NM_ICOUPLANENT_MOD';	
                
        $this->tipo_procedimiento='IME';
        
        $ext = pathinfo($this->arregloFiles['archivo']['name']);
        $this->arreglo['extension']= $ext['extension'];
        
        //Define los parametros para la funcion 
        $this->setParametro('id_plantilla_entidad','id_plantilla_entidad','integer'); 
		$this->setParametro('extension_archivo','extension','varchar');
		$this->setFile('archivo','id_plantilla_entidad', false, '', array('doc','pdf','docx','jpg','jpeg','bmp','gif','png'));
                
        //Ejecuta la instruccion
        $this->armarConsulta();
                
        $this->ejecutarConsulta();
        return $this->respuesta;
    }
			
}
?>