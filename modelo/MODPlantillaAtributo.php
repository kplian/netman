<?php
/**
*@package pXP
*@file gen-MODPlantillaAtributo.php
*@author  (admin)
*@date 16-12-2013 18:42:43
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODPlantillaAtributo extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarPlantillaAtributo(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='netman.ft_plantilla_atributo_sel';
		$this->transaccion='NM_PLANAT_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		
		$this->setParametro('id_plantilla_entidad','id_plantilla_entidad','int4'); 
				
		//Definicion de la lista del resultado del query
		$this->captura('id_plantilla_atributo','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('descripcion','text');
		$this->captura('id_plantilla_entidad','int4');
		$this->captura('nombre','varchar');
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
			
	function insertarPlantillaAtributo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='netman.ft_plantilla_atributo_ime';
		$this->transaccion='NM_PLANAT_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('descripcion','descripcion','text');
		$this->setParametro('id_plantilla_entidad','id_plantilla_entidad','int4');
		$this->setParametro('nombre','nombre','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarPlantillaAtributo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='netman.ft_plantilla_atributo_ime';
		$this->transaccion='NM_PLANAT_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_plantilla_atributo','id_plantilla_atributo','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('descripcion','descripcion','text');
		$this->setParametro('id_plantilla_entidad','id_plantilla_entidad','int4');
		$this->setParametro('nombre','nombre','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarPlantillaAtributo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='netman.ft_plantilla_atributo_ime';
		$this->transaccion='NM_PLANAT_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_plantilla_atributo','id_plantilla_atributo','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>