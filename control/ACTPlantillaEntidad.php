<?php
/**
*@package pXP
*@file gen-ACTPlantillaEntidad.php
*@author  (admin)
*@date 16-12-2013 17:20:55
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTPlantillaEntidad extends ACTbase{    
			
	function listarPlantillaEntidad(){
		$this->objParam->defecto('ordenacion','id_plantilla_entidad');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPlantillaEntidad','listarPlantillaEntidad');
		} else{
			$this->objFunc=$this->create('MODPlantillaEntidad');
			
			$this->res=$this->objFunc->listarPlantillaEntidad($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function listarPlantillaEntidadCmb(){
		$this->objParam->defecto('ordenacion','id_plantilla_entidad');
		$this->objParam->addFiltro("plaen.estado = ''closed''");
		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPlantillaEntidad','listarPlantillaEntidad');
		} else{
			$this->objFunc=$this->create('MODPlantillaEntidad');
			
			$this->res=$this->objFunc->listarPlantillaEntidad($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function listarPlantillaEntidadArb(){
		
		$this->objFunc=$this->create('MODPlantillaEntidad');
		$this->res=$this->objFunc->listarPlantillaEntidadArb($this->objParam);
		
		$this->res->setTipoRespuestaArbol();
		
		$arreglo=array();
		//array_push($arreglo,array('nombre'=>'id','valor'=>'id_gui'));
		array_push($arreglo,array('nombre'=>'id','valor'=>'id_estructura_plantilla'));		
		array_push($arreglo,array('nombre'=>'text','valor'=>'nombre'));
		array_push($arreglo,array('nombre'=>'id_p','valor'=>'id_estructura_plantilla_p'));
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


				
	function insertarPlantillaEntidad(){
		$this->objFunc=$this->create('MODPlantillaEntidad');	
		if($this->objParam->insertar('id_plantilla_entidad')){
			$this->res=$this->objFunc->insertarPlantillaEntidad($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarPlantillaEntidad($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function insertarPlantillaEntidadArb(){
		$this->objFunc=$this->create('MODPlantillaEntidad');	
		$this->res=$this->objFunc->insertarPlantillaEntidadArb($this->objParam);			
		
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarPlantillaEntidad(){
			$this->objFunc=$this->create('MODPlantillaEntidad');	
		$this->res=$this->objFunc->eliminarPlantillaEntidad($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function eliminarPlantillaEntidadArb(){
			$this->objFunc=$this->create('MODPlantillaEntidad');	
		$this->res=$this->objFunc->eliminarPlantillaEntidadArb($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function subirArchivo(){
        $this->objFunc=$this->create('MODPlantillaEntidad');
        $this->res=$this->objFunc->subirArchivo();
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
			
}

?>