CREATE OR REPLACE FUNCTION netman.ft_entidad_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Network Manager
 FUNCION: 		netman.ft_entidad_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'netman.tentidad'
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

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_entidad	integer;
	v_estado				varchar;
	v_id_estructura_plantilla	integer;
			    
BEGIN

    v_nombre_funcion = 'netman.ft_entidad_ime';
    v_parametros = pxp.f_get_record(p_tabla);

			
	/*********************************    
 	#TRANSACCION:  'NM_ENTIARB_INS'
 	#DESCRIPCION:	Insercion de registros en estructura entidad
 	#AUTOR:		admin	
 	#FECHA:		16-12-2013 17:20:55
	***********************************/

	if(p_transaccion='NM_ENTIARB_INS')then
					
        begin
        
        	v_resp = (select netman.f_insertar_plantilla(v_parametros.id_plantilla_entidad, v_parametros.id_entidad_padre,v_parametros.descripcion,'si',p_id_usuario));        	
        	
        				
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Estructura Entidad almacenado(a) con exito'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_plantilla_entidad',v_parametros.id_plantilla_entidad::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'NM_ENTI_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		16-12-2013 17:20:55
	***********************************/

	elsif(p_transaccion='NM_ENTI_MOD')then

		begin
			--Sentencia de la modificacion
					
			if (v_parametros.id_entidad_relacion is not null) then
				if (v_parametros.desconectar = 'si')then
					update netman.tentidad set
					id_entidad_relacion = null
					where id_entidad=v_parametros.id_entidad_relacion;
					
					update netman.tentidad set
					id_entidad_relacion = null
					where id_entidad=v_parametros.id_entidad;
				
				else
					
					update netman.tentidad set
					id_entidad_relacion = v_parametros.id_entidad_relacion
					where id_entidad=v_parametros.id_entidad;
				
					update netman.tentidad set
					id_entidad_relacion = v_parametros.id_entidad
					where id_entidad=v_parametros.id_entidad_relacion;
				end if;
			else
				update netman.tentidad set
				nombre = v_parametros.nombre,
				codigo = v_parametros.codigo,
				codigo_af = v_parametros.codigo_af,
				observaciones = v_parametros.observaciones,
				fecha_mod = now(),
				id_usuario_mod = p_id_usuario
				where id_entidad=v_parametros.id_entidad;
			end if;
			
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Entidad modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_entidad',v_parametros.id_entidad::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;
		
		
	/*********************************    
 	#TRANSACCION:  'NM_ENTIARB_ELI'
 	#DESCRIPCION:	Eliminacion de registros de estructura_entidad
 	#AUTOR:		admin	
 	#FECHA:		16-12-2013 17:20:55
	***********************************/

	elsif(p_transaccion='NM_ENTIARB_ELI')then

		begin
			--Sentencia de la eliminacion
			
			if (exists( select 1 
						from netman.tentidad en
						inner join netman.testructura_entidad esen
							on esen.id_entidad_hijo = en.id_entidad
						where esen.id_estructura_entidad = v_parametros.id_estructura_entidad and en.eliminable = 'no')) then
				raise exception 'No es posible eliminar esta entidad, intente con una superior';
			end if;
			
            v_resp = (select netman.f_eliminar_entidad(v_parametros.id_estructura_entidad));        	
        	   
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Estructura Entidad eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_estructura_entidad',v_parametros.id_estructura_entidad::varchar);
              
            --Devuelve la respuesta
            return v_resp;

		end;
	         
	else
     
    	raise exception 'Transaccion inexistente: %',p_transaccion;

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