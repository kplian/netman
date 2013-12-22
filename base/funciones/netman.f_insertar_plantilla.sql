CREATE OR REPLACE FUNCTION netman.f_insertar_plantilla (
  p_id_plantilla_entidad integer,
  p_id_entidad_padre integer,
  p_descripcion varchar,
  p_eliminable varchar,
  p_id_usuario	integer
)
RETURNS varchar AS
$body$
/**************************************************************************
 FUNCION: 		netman.f_insertar_plantilla
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


	v_nombre_funcion:='netman.f_insertar_plantilla';
	select * into v_registros
    from netman.tplantilla_entidad
    where id_plantilla_entidad = p_id_plantilla_entidad;
    
    --insert entidad    
    insert into netman.tentidad (id_plantilla_entidad, nombre, eliminable, id_usuario_reg) 
    values(p_id_plantilla_entidad, v_registros.nombre, p_eliminable, p_id_usuario) 
    returning id_entidad into v_id_entidad;
    
    --insert entidad_estructura
    if (p_id_entidad_padre is null) then
    	insert into netman.testructura_entidad (id_entidad_padre,id_entidad_hijo,descripcion)
        values(0,v_id_entidad,p_descripcion);
    else
    	insert into netman.testructura_entidad (id_entidad_padre,id_entidad_hijo,descripcion)
        values(p_id_entidad_padre,v_id_entidad,p_descripcion);
    end if;
    
    --insert entidad_atributo
    for v_registros in (select * 
    					from netman.tplantilla_atributo 
                        where id_plantilla_entidad = p_id_plantilla_entidad)loop
    	insert into netman.tatributo (id_plantilla_atributo, id_entidad, id_usuario_reg)
        values(v_registros.id_plantilla_atributo, v_id_entidad,p_id_usuario);
    	
    end loop; 
    
    --insert entidades detalle
    for v_registros in (select * 
    					from netman.testructura_plantilla 
                        where id_plantilla_padre = p_id_plantilla_entidad)loop
    	v_resp = (select netman.f_insertar_plantilla(v_registros.id_plantilla_hijo, 
        											v_id_entidad,v_registros.descripcion,'no',p_id_usuario));
    	
    end loop; 
    
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