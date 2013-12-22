<?php
/**
*@package pXP
*@file gen-MODArchivo.php
*@author  (admin)
*@date 17-12-2013 17:20:07
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODArchivo extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarArchivo(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='netman.ft_archivo_sel';
		$this->transaccion='NM_ARCHI_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
						
		//Definicion de la lista del resultado del query
		$this->captura('id_archivo','int4');
		$this->captura('id_entidad','int4');
		$this->captura('id_plantilla_entidad','int4');
		$this->captura('extension','varchar');
		$this->captura('nombre_doc','varchar');
		$this->captura('nombre_arch_doc','varchar');
		$this->captura('estado_reg','varchar');
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
			
	function insertarArchivo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='netman.ft_archivo_ime';
		$this->transaccion='NM_ARCHI_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_entidad','id_entidad','int4');
		$this->setParametro('id_plantilla_entidad','id_plantilla_entidad','int4');
		$this->setParametro('extension','extension','varchar');
		$this->setParametro('nombre_doc','nombre_doc','varchar');
		$this->setParametro('nombre_arch_doc','nombre_arch_doc','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarArchivo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='netman.ft_archivo_ime';
		$this->transaccion='NM_ARCHI_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_archivo','id_archivo','int4');
		$this->setParametro('id_entidad','id_entidad','int4');
		$this->setParametro('id_plantilla_entidad','id_plantilla_entidad','int4');
		$this->setParametro('extension','extension','varchar');
		$this->setParametro('nombre_doc','nombre_doc','varchar');
		$this->setParametro('nombre_arch_doc','nombre_arch_doc','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarArchivo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='netman.ft_archivo_ime';
		$this->transaccion='NM_ARCHI_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_archivo','id_archivo','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}


	function subirArchivo(){
        $this->procedimiento='netman.ft_archivo_ime';
        
        $this->transaccion='NM_UPLARCH_MOD';	
                
        $this->tipo_procedimiento='IME';
        
        $ext = pathinfo($this->arregloFiles['archivo']['name']);
		
        $this->arreglo['extension']= $ext['extension'];
		$this->arreglo['nombre_arch_doc']= $this->arregloFiles['archivo']['name'];
		
        
        //Define los parametros para la funcion 
        $this->setParametro('id_archivo','id_archivo','integer'); 
		$this->setParametro('nombre_arch_doc','nombre_arch_doc','varchar');
		$this->setParametro('extension','extension','varchar');
		$this->setFile('archivo','id_archivo', false, '', array('doc','pdf','docx','jpg','jpeg','bmp','gif','png'));
                
        //Ejecuta la instruccion
        $this->armarConsulta();
                
        $this->ejecutarConsulta();
        return $this->respuesta;
    }
			
}
?>