<?php
/**
*@package pXP
*@file gen-MODPlantillaEntidad.php
*@author  (admin)
*@date 16-12-2013 17:20:55
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODEntidad extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarEntidad(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='netman.ft_entidad_sel';
		$this->transaccion='NM_ENTI_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_entidad','int4');
		$this->captura('id_plantilla_entidad','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('tipo_entidad','varchar');
		$this->captura('nombre','varchar');
		$this->captura('modelo','varchar');
		$this->captura('marca','varchar');
		$this->captura('descripcion','text');
		$this->captura('codigo','varchar');
		$this->captura('codigo_af','varchar');
		$this->captura('observaciones','text');
		
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('id_entidad_relacion','integer');
		$this->captura('desc_entidad_relacion','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}

	function listarEntidadArb(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='netman.ft_entidad_sel';
		$this->transaccion='NM_ENTIARB_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		$this->setCount(false);	
		
		$this->setParametro('id_entidad','id_entidad','integer');
		
		//Definicion de la lista del resultado del query
		$this->captura('id_estructura_entidad','int4');
		$this->captura('id_entidad_padre','int4');
		$this->captura('id_entidad','int4');
		$this->captura('nombre','varchar');
		$this->captura('eliminable','varchar');
		$this->captura('icono','varchar');
		$this->captura('tipo_nodo','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarEntidadArb(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='netman.ft_entidad_ime';
		$this->transaccion='NM_ENTIARB_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_plantilla_entidad','id_plantilla_entidad','integer');
		$this->setParametro('id_entidad_padre','id_entidad_padre','integer');
		$this->setParametro('descripcion','descripcion','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarEntidad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='netman.ft_entidad_ime';
		$this->transaccion='NM_ENTI_MOD';
		$this->tipo_procedimiento='IME';
						
		//Define los parametros para la funcion
		$this->setParametro('id_entidad','id_entidad','int4');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('codigo','codigo','varchar');
		$this->setParametro('codigo_af','codigo_af','varchar');
		$this->setParametro('observaciones','observaciones','text');
		$this->setParametro('id_entidad_relacion','id_entidad_relacion','int4');
		$this->setParametro('desconectar','desconectar','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
		
	
	function eliminarEntidadArb(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='netman.ft_entidad_ime';
		$this->transaccion='NM_ENTIARB_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_estructura_entidad','id_estructura_entidad','int4');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
				
}
?>