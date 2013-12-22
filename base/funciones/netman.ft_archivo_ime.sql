CREATE OR REPLACE FUNCTION "netman"."ft_archivo_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Network Manager
 FUNCION: 		netman.ft_archivo_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'netman.tarchivo'
 AUTOR: 		 (admin)
 FECHA:	        17-12-2013 17:20:07
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
	v_id_archivo	integer;
	v_estado				varchar;
			    
BEGIN

    v_nombre_funcion = 'netman.ft_archivo_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'NM_ARCHI_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		17-12-2013 17:20:07
	***********************************/

	if(p_transaccion='NM_ARCHI_INS')then
					
        begin
        	if (v_parametros.id_plantilla_entidad is not null) then
	        	select estado into v_estado
				from netman.tplantilla_entidad
				where id_plantilla_entidad = v_parametros.id_plantilla_entidad;
				
				if (v_estado = 'closed') then
					raise exception 'La plantilla esta cerrada';
				end if;  
			end if;
        	
        	--Sentencia de la insercion
        	insert into netman.tarchivo(
			id_entidad,
			id_plantilla_entidad,
			nombre_doc,
			estado_reg,
			fecha_reg,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.id_entidad,
			v_parametros.id_plantilla_entidad,
			v_parametros.nombre_doc,
			'activo',
			now(),
			p_id_usuario,
			null,
			null
							
			)RETURNING id_archivo into v_id_archivo;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Documentos almacenado(a) con exito (id_archivo'||v_id_archivo||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_archivo',v_id_archivo::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'NM_ARCHI_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		17-12-2013 17:20:07
	***********************************/

	elsif(p_transaccion='NM_ARCHI_MOD')then

		begin
			
			
	        select pe.estado into v_estado
			from netman.tplantilla_entidad pe
			inner join netman.tarchivo ar on ar.id_plantilla_entidad = pe.id_plantilla_entidad
			where ar.id_archivo = v_parametros.id_archivo;
				
			if (v_estado = 'closed') then
				raise exception 'La plantilla esta cerrada';
			end if;
			  
			
		
			--Sentencia de la modificacion
			update netman.tarchivo set
			nombre_doc = v_parametros.nombre_doc,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario
			where id_archivo=v_parametros.id_archivo;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Documentos modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_archivo',v_parametros.id_archivo::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;
		/*********************************    
	 	#TRANSACCION:  'NM_UPLARCH_MOD'
	 	#DESCRIPCION:	Upload Archivos
	 	#AUTOR:		admin	
	 	#FECHA:		17-12-2013 17:20:07
		***********************************/
		
		elsif(p_transaccion='NM_UPLARCH_MOD')then

		begin
			--Sentencia de la modificacion
			
			
	        select pe.estado into v_estado
			from netman.tplantilla_entidad pe
			inner join netman.tarchivo ar on ar.id_plantilla_entidad = pe.id_plantilla_entidad
			where ar.id_archivo = v_parametros.id_archivo;
				
			if (v_estado = 'closed') then
				raise exception 'La plantilla esta cerrada';
			end if;
			  
			
			update netman.tarchivo set
			extension = v_parametros.extension,
			nombre_arch_doc = v_parametros.nombre_arch_doc,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario
			where id_archivo=v_parametros.id_archivo;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Documentos modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_archivo',v_parametros.id_archivo::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;
		

	/*********************************    
 	#TRANSACCION:  'NM_ARCHI_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		17-12-2013 17:20:07
	***********************************/

	elsif(p_transaccion='NM_ARCHI_ELI')then

		begin
			
        	select pe.estado into v_estado
			from netman.tplantilla_entidad pe
			inner join netman.tarchivo ar on ar.id_plantilla_entidad = pe.id_plantilla_entidad
			where ar.id_archivo = v_parametros.id_archivo;
			
			if (v_estado = 'closed') then
				raise exception 'La plantilla esta cerrada';
			end if;
			  
			--Sentencia de la eliminacion
			delete from netman.tarchivo
            where id_archivo=v_parametros.id_archivo;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Documentos eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_archivo',v_parametros.id_archivo::varchar);
              
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
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "netman"."ft_archivo_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
