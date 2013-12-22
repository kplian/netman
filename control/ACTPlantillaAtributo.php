<?php
/**
*@package pXP
*@file gen-ACTPlantillaAtributo.php
*@author  (admin)
*@date 16-12-2013 18:42:43
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTPlantillaAtributo extends ACTbase{    
			
	function listarPlantillaAtributo(){
		$this->objParam->defecto('ordenacion','id_plantilla_atributo');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPlantillaAtributo','listarPlantillaAtributo');
		} else{
			$this->objFunc=$this->create('MODPlantillaAtributo');
			
			$this->res=$this->objFunc->listarPlantillaAtributo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarPlantillaAtributo(){
		$this->objFunc=$this->create('MODPlantillaAtributo');	
		if($this->objParam->insertar('id_plantilla_atributo')){
			$this->res=$this->objFunc->insertarPlantillaAtributo($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarPlantillaAtributo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarPlantillaAtributo(){
			$this->objFunc=$this->create('MODPlantillaAtributo');	
		$this->res=$this->objFunc->eliminarPlantillaAtributo($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>