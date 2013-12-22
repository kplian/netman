<?php
/**
*@package pXP
*@file gen-ACTArchivo.php
*@author  (admin)
*@date 17-12-2013 17:20:07
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTArchivo extends ACTbase{    
			
	function listarArchivo(){
		$this->objParam->defecto('ordenacion','id_archivo');

		$this->objParam->defecto('dir_ordenacion','asc');
		
		if ($this->objParam->getParametro('id_plantilla_entidad') != '' && $this->objParam->getParametro('id_entidad') != '') {
			$this->objParam->addFiltro("(archi.id_entidad = " . $this->objParam->getParametro('id_entidad') . 
										" or archi.id_plantilla_entidad = " . $this->objParam->getParametro('id_plantilla_entidad') . ")");
		} else if ($this->objParam->getParametro('id_plantilla_entidad') != '') {
			$this->objParam->addFiltro("archi.id_plantilla_entidad = " . $this->objParam->getParametro('id_plantilla_entidad'));
		}
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODArchivo','listarArchivo');
		} else{
			$this->objFunc=$this->create('MODArchivo');
			
			$this->res=$this->objFunc->listarArchivo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarArchivo(){
		$this->objFunc=$this->create('MODArchivo');	
		if($this->objParam->insertar('id_archivo')){
			$this->res=$this->objFunc->insertarArchivo($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarArchivo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarArchivo(){
			$this->objFunc=$this->create('MODArchivo');	
		$this->res=$this->objFunc->eliminarArchivo($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function subirArchivo(){
        $this->objFunc=$this->create('MODArchivo');
        $this->res=$this->objFunc->subirArchivo();
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
			
}

?>