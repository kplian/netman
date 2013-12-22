CREATE OR REPLACE FUNCTION "netman"."ft_plantilla_atributo_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Network Manager
 FUNCION: 		netman.ft_plantilla_atributo_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'netman.tplantilla_atributo'
 AUTOR: 		 (admin)
 FECHA:	        16-12-2013 18:42:43
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
	v_id_plantilla_atributo	integer;
	v_estado				varchar;
			    
BEGIN

    v_nombre_funcion = 'netman.ft_plantilla_atributo_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'NM_PLANAT_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		16-12-2013 18:42:43
	***********************************/

	if(p_transaccion='NM_PLANAT_INS')then
					
        begin
        
        	select estado into v_estado
			from netman.tplantilla_entidad
			where id_plantilla_entidad = v_parametros.id_plantilla_entidad;
			
			if (v_estado = 'closed') then
				raise exception 'La plantilla esta cerrada';
			end if;  
			
			
        	--Sentencia de la insercion
        	insert into netman.tplantilla_atributo(
			estado_reg,
			descripcion,
			id_plantilla_entidad,
			nombre,
			fecha_reg,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			'activo',
			v_parametros.descripcion,
			v_parametros.id_plantilla_entidad,
			v_parametros.nombre,
			now(),
			p_id_usuario,
			null,
			null
							
			)RETURNING id_plantilla_atributo into v_id_plantilla_atributo;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Plantilla Atributo almacenado(a) con exito (id_plantilla_atributo'||v_id_plantilla_atributo||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_plantilla_atributo',v_id_plantilla_atributo::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'NM_PLANAT_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		16-12-2013 18:42:43
	***********************************/

	elsif(p_transaccion='NM_PLANAT_MOD')then

		begin
			select estado into v_estado
			from netman.tplantilla_entidad
			where id_plantilla_entidad = v_parametros.id_plantilla_entidad;
			
			if (v_estado = 'closed') then
				raise exception 'La plantilla esta cerrada';
			end if;  
			
			
			--Sentencia de la modificacion
			update netman.tplantilla_atributo set
			descripcion = v_parametros.descripcion,
			id_plantilla_entidad = v_parametros.id_plantilla_entidad,
			nombre = v_parametros.nombre,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario
			where id_plantilla_atributo=v_parametros.id_plantilla_atributo;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Plantilla Atributo modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_plantilla_atributo',v_parametros.id_plantilla_atributo::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'NM_PLANAT_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		16-12-2013 18:42:43
	***********************************/

	elsif(p_transaccion='NM_PLANAT_ELI')then

		begin
			--Sentencia de la eliminacion
			
			
	        select pe.estado into v_estado
			from netman.tplantilla_entidad pe
			inner join netman.tplantilla_atributo pa on pa.id_plantilla_entidad = pe.id_plantilla_entidad
			where pa.id_plantilla_atributo = v_parametros.id_plantilla_atributo;
			
			if (v_estado = 'closed') then
				raise exception 'La plantilla esta cerrada';
			end if;
			   
			
			
			delete from netman.tplantilla_atributo
            where id_plantilla_atributo=v_parametros.id_plantilla_atributo;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Plantilla Atributo eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_plantilla_atributo',v_parametros.id_plantilla_atributo::varchar);
              
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
ALTER FUNCTION "netman"."ft_plantilla_atributo_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
