<?php
/**
*@package pXP
*@file gen-ACTAtributo.php
*@author  (admin)
*@date 16-12-2013 18:42:43
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTAtributo extends ACTbase{    
			
	function listarAtributo(){
		$this->objParam->defecto('ordenacion','id_atributo');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODAtributo','listarAtributo');
		} else{
			$this->objFunc=$this->create('MODAtributo');
			
			$this->res=$this->objFunc->listarAtributo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarAtributo(){
		$this->objFunc=$this->create('MODAtributo');	
		$this->res=$this->objFunc->modificarAtributo($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}				
}

?>