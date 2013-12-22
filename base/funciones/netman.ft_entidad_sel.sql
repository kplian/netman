CREATE OR REPLACE FUNCTION netman.ft_entidad_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Network Manager
 FUNCION: 		netman.ft_entidad_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'netman.tentidad'
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

	v_nombre_funcion = 'netman.ft_entidad_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'NM_ENTI_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		16-12-2013 17:20:55
	***********************************/

	if(p_transaccion='NM_ENTI_SEL')then
     				
    	begin
    		--Sentencia de la consulta
    		
			v_consulta:='select
						en.id_entidad,
						en.id_plantilla_entidad,
						en.estado_reg,
						plaen.tipo_entidad,
						en.nombre,
						plaen.modelo,
						plaen.marca,
						plaen.descripcion,
						en.codigo,
						en.codigo_af,
						en.observaciones,
						en.fecha_reg,
						en.id_usuario_reg,
						en.fecha_mod,
						en.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
						en.id_entidad_relacion,
						netman.f_get_descripcion_entidad(en.id_entidad_relacion)
						from netman.tentidad en
						inner join netman.tplantilla_entidad plaen
							on plaen.id_plantilla_entidad = en.id_plantilla_entidad
						inner join segu.tusuario usu1 on usu1.id_usuario = en.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = en.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			--raise notice '%', v_consulta;
			--Devuelve la respuesta
			return v_consulta;
						
		end;
    elsif(p_transaccion='NM_ENTIARB_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						esen.id_estructura_entidad,
						esen.id_entidad_padre,
						esen.id_entidad_hijo,
                        (plaen.tipo_entidad || ''-''|| en.nombre|| '' ''|| plaen.marca|| '' ''|| plaen.modelo|| ''--- ''|| esen.descripcion)::varchar,
						en.eliminable,
						(''../../../uploaded_files/sis_netman/PlantillaEntidad/'' || md5(plaen.id_plantilla_entidad || ''+_)(*&^%$#@!@TERPODO'') || ''.'' || plaen.icono)::varchar,
                        ''unico''::varchar							
						from netman.testructura_entidad esen 
                        inner join netman.tentidad en 
                        	on esen.id_entidad_hijo = en.id_entidad
                        inner join netman.tplantilla_entidad plaen
                        	on plaen.id_plantilla_entidad = en.id_plantilla_entidad
						where  ';
			if (v_parametros.id_entidad is not null) then
            	v_consulta:=v_consulta|| ' esen.id_entidad_padre = ' || v_parametros.id_entidad || ' and ';
            else 
            	v_consulta:=v_consulta|| ' esen.id_entidad_padre = 0 and';
            end if;	
            
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			
			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'NM_ENTI_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		16-12-2013 17:20:55
	***********************************/

	elsif(p_transaccion='NM_ENTI_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(en.id_entidad)
					    from netman.tentidad en
						inner join netman.tplantilla_entidad plaen
							on plaen.id_plantilla_entidad = en.id_plantilla_entidad
					    inner join segu.tusuario usu1 on usu1.id_usuario = en.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = en.id_usuario_mod
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