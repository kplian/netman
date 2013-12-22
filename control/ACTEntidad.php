<?php
/**
*@package pXP
*@file gen-ACTEntidad.php
*@author  (admin)
*@date 16-12-2013 17:20:55
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTEntidad extends ACTbase{    
			
	function listarEntidadArb(){
		
		$this->objFunc=$this->create('MODEntidad');
		$this->res=$this->objFunc->listarEntidadArb($this->objParam);
		
		$this->res->setTipoRespuestaArbol();
		
		$arreglo=array();
		//array_push($arreglo,array('nombre'=>'id','valor'=>'id_gui'));
		array_push($arreglo,array('nombre'=>'id','valor'=>'id_estructura_entidad'));		
		array_push($arreglo,array('nombre'=>'text','valor'=>'nombre'));
		array_push($arreglo,array('nombre'=>'id_p','valor'=>'id_estructura_entidad_p'));
		array_push($arreglo,array('nombre'=>'cls','valor'=>'descripcion'));
		array_push($arreglo,array('nombre'=>'icon','valor'=>'icono'));
		
		/*se ande un nivel al arbol incluyendo con tido de nivel carpeta con su arreglo de equivalencias
		  es importante que entre los resultados devueltos por la base exista la variable\
		  tipo_dato que tenga el valor en texto = 'hoja' */
		 														

		 $this->res->addNivelArbol('tipo_nodo','unico',array(
														'leaf'=>false,
														'allowDelete'=>true,
														'allowEdit'=>false),
		 												$arreglo);
			

		//Se imprime el arbol en formato JSON
		$this->res->imprimirRespuesta($this->res->generarJson());
		
		

	}

	function listarEntidad(){
		$this->objParam->defecto('ordenacion','id_entidad');
		
		$this->objParam->defecto('dir_ordenacion','asc');
		if ($this->objParam->getParametro('id_entidad') != '') {
			$this->objParam->addFiltro("en.id_entidad = " . $this->objParam->getParametro('id_entidad'));
		}
		
		if ($this->objParam->getParametro('id_entidad_equipo') != '') {
			$this->objParam->addFiltro("en.id_entidad in (select id_entidad_hijo from netman.testructura_entidad where id_entidad_padre = " . $this->objParam->getParametro('id_entidad_equipo') . ")");
		}
		
		if ($this->objParam->getParametro('id_entidad_negar') != '') {
			$this->objParam->addFiltro("en.id_entidad != " . $this->objParam->getParametro('id_entidad_negar') . " and en.id_entidad_relacion is null");
		}
		
		if ($this->objParam->getParametro('tipo_entidad') != '') {
			$this->objParam->addFiltro("plaen.tipo_entidad = ''" . $this->objParam->getParametro('tipo_entidad') . "''");
		}
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODEntidad','listarEntidad');
		} else{
			$this->objFunc=$this->create('MODEntidad');			
			$this->res=$this->objFunc->listarEntidad($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function insertarEntidadArb(){
		$this->objFunc=$this->create('MODEntidad');	
		$this->res=$this->objFunc->insertarEntidadArb($this->objParam);			
		
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
		
	function eliminarEntidadArb(){
			$this->objFunc=$this->create('MODEntidad');	
		$this->res=$this->objFunc->eliminarEntidadArb($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function insertarEntidad(){
		$this->objFunc=$this->create('MODEntidad');	
		$this->res=$this->objFunc->modificarEntidad($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}			
}

?>