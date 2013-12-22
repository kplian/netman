CREATE OR REPLACE FUNCTION netman.ft_plantilla_entidad_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Network Manager
 FUNCION: 		netman.ft_plantilla_entidad_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'netman.tplantilla_entidad'
 AUTOR: 		 (admin)
 FECHA:	        16-12-2013 17:20:55
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:		
***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'netman.ft_plantilla_entidad_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'NM_PLAEN_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		16-12-2013 17:20:55
	***********************************/

	if(p_transaccion='NM_PLAEN_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						plaen.id_plantilla_entidad,
						plaen.estado_reg,
						plaen.estado,
						plaen.tipo_entidad,
						plaen.nombre,
						plaen.modelo,
						plaen.marca,
						plaen.icono,
						plaen.descripcion,
						plaen.fecha_reg,
						plaen.id_usuario_reg,
						plaen.fecha_mod,
						plaen.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from netman.tplantilla_entidad plaen
						inner join segu.tusuario usu1 on usu1.id_usuario = plaen.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = plaen.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;
    elsif(p_transaccion='NM_PLAENARB_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						espla.id_estructura_plantilla,
						espla.id_plantilla_padre,
						espla.id_plantilla_hijo,
                        plaen.tipo_entidad,
						(plaen.tipo_entidad || ''-''|| plaen.nombre|| '' ''|| plaen.marca|| '' ''|| plaen.modelo|| ''--- ''|| espla.descripcion)::varchar,
						plaen.modelo,
						plaen.marca,
						(''../../../uploaded_files/sis_netman/PlantillaEntidad/'' || md5(id_plantilla_hijo || ''+_)(*&^%$#@!@TERPODO'') || ''.'' || plaen.icono)::varchar,
                        ''unico''::varchar							
						from netman.testructura_plantilla espla 
                        inner join netman.tplantilla_entidad plaen 
                        	on espla.id_plantilla_hijo = plaen.id_plantilla_entidad
						where  ';
            v_consulta:=v_consulta|| ' espla.id_plantilla_padre = ' || v_parametros.id_plantilla_entidad || ' and ';
            			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			
			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'NM_PLAEN_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		16-12-2013 17:20:55
	***********************************/

	elsif(p_transaccion='NM_PLAEN_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_plantilla_entidad)
					    from netman.tplantilla_entidad plaen
					    inner join segu.tusuario usu1 on usu1.id_usuario = plaen.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = plaen.id_usuario_mod
					    where ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
					
	else
					     
		raise exception 'Transaccion inexistente';
					         
	end if;
					
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