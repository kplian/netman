CREATE OR REPLACE FUNCTION netman.f_eliminar_entidad (
  p_id_estructura_entidad integer
)
RETURNS varchar AS
$body$
/**************************************************************************
 FUNCION: 		netman.f_eliminar_entidad
 DESCRIPCION:   
 AUTOR: 		KPLIAN(jrr)
 FECHA:	
 COMENTARIOS:	
***************************************************************************/
DECLARE
v_esquema         varchar;
v_mensaje_error   text;
v_nombre_funcion  varchar;
v_resp          varchar;
v_registros		record;
v_registros_hijos record;
v_id_entidad	integer;

BEGIN


	v_nombre_funcion:='netman.f_eliminar_entidad';
	select en.* into v_registros
    from netman.tentidad en
    inner join netman.testructura_entidad esen
    	on esen.id_entidad_hijo = en.id_entidad
    where esen.id_estructura_entidad = p_id_estructura_entidad;
    
    --eliminar entidades relacionadas    
    --insert entidades detalle
    for v_registros_hijos in (select * 
    					from netman.testructura_entidad 
                        where id_entidad_padre = v_registros.id_entidad)loop
    	v_resp = (select netman.f_eliminar_entidad(v_registros_hijos.id_estructura_entidad));
    	
    end loop;
    
    
    
    --eliminar entidad_atributo
    delete from netman.tatributo where id_entidad = v_registros.id_entidad;
    
    --eliminar entidad_archivo
    delete from netman.tarchivo where id_entidad = v_registros.id_entidad;
    
    --eliminar estructura_entidad
    delete from netman.testructura_entidad where id_estructura_entidad = p_id_estructura_entidad;
    
    --eliminar entidad
    delete from netman.tentidad where id_entidad = v_registros.id_entidad;
     
    
    return 'exito';

EXCEPTION
      WHEN OTHERS THEN
    	v_resp='';
		v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
    	v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
  		v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
		raise exception '%',v_resp;


END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;