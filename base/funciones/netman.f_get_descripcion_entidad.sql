CREATE OR REPLACE FUNCTION netman.f_get_descripcion_entidad (
  p_id_entidad integer
)
RETURNS varchar AS
$body$
/**************************************************************************
 FUNCION: 		netman.f_get_descripcion_entidad
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
v_id_entidad	integer;

BEGIN

	v_nombre_funcion:='netman.f_get_descripcion_entidad';
	
	select (equipo.nombre || ' - '||coalesce(equipo.codigo,'') || ' ==> '|| puerto.nombre || ' - '||coalesce(puerto.codigo,''))::varchar into v_resp 
	from netman.tentidad puerto
	inner join netman.testructura_entidad es
		on es.id_entidad_hijo = puerto.id_entidad
	inner join netman.tentidad equipo 
		on equipo.id_entidad = es.id_entidad_padre
	where puerto.id_entidad = p_id_entidad;
	
	return v_resp;
	
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