CREATE OR REPLACE FUNCTION "netman"."ft_plantilla_entidad_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Network Manager
 FUNCION: 		netman.ft_plantilla_entidad_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'netman.tplantilla_entidad'
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
	v_id_plantilla_entidad	integer;
	v_estado				varchar;
	v_id_estructura_plantilla	integer;
			    
BEGIN

    v_nombre_funcion = 'netman.ft_plantilla_entidad_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'NM_PLAEN_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		16-12-2013 17:20:55
	***********************************/

	if(p_transaccion='NM_PLAEN_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into netman.tplantilla_entidad(
			estado_reg,
			estado,
			tipo_entidad,
			nombre,
			modelo,
			marca,
			descripcion,
			fecha_reg,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			'activo',
			'open',
			v_parametros.tipo_entidad,
			v_parametros.nombre,
			v_parametros.modelo,
			v_parametros.marca,
			v_parametros.descripcion,
			now(),
			p_id_usuario,
			null,
			null
							
			)RETURNING id_plantilla_entidad into v_id_plantilla_entidad;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Plantilla Entidad almacenado(a) con exito (id_plantilla_entidad'||v_id_plantilla_entidad||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_plantilla_entidad',v_id_plantilla_entidad::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;
		
	/*********************************    
 	#TRANSACCION:  'NM_PLAENARB_INS'
 	#DESCRIPCION:	Insercion de registros en estructura planilla
 	#AUTOR:		admin	
 	#FECHA:		16-12-2013 17:20:55
	***********************************/

	elsif(p_transaccion='NM_PLAENARB_INS')then
					
        begin
        
        	if (exists (select 1 
        				from netman.testructura_plantilla
        				where id_plantilla_padre = v_parametros.id_plantilla_entidad and
        						id_plantilla_hijo = v_parametros.id_plantilla_padre)) then
        	
        		raise exception 'No se pueden crear relaciones recursivas';
        	end if;
        	
        	--Sentencia de la modificacion
			select estado into v_estado
			from netman.tplantilla_entidad
			where id_plantilla_entidad = v_parametros.id_plantilla_padre;
			
			if (v_estado = 'closed') then
				raise exception 'No es posible añadir elementos, la plantilla esta cerrada';
			end if; 
        	
        	--Sentencia de la insercion
        	insert into netman.testructura_plantilla(
			id_plantilla_padre,
			id_plantilla_hijo,
			estado_reg,
			fecha_reg,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod,
			descripcion
          	) values(
          	v_parametros.id_plantilla_padre,
          	v_parametros.id_plantilla_entidad,
			'activo',
			now(),
			p_id_usuario,
			null,
			null,
			v_parametros.descripcion
							
			)RETURNING id_estructura_plantilla into v_id_estructura_plantilla;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Estructura Plantilla almacenado(a) con exito (id_estructura_plantilla'||v_id_estructura_plantilla||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_estructura_plantilla',v_id_estructura_plantilla::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'NM_PLAEN_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		16-12-2013 17:20:55
	***********************************/

	elsif(p_transaccion='NM_PLAEN_MOD')then

		begin
			--Sentencia de la modificacion
			select estado into v_estado
			from netman.tplantilla_entidad
			where id_plantilla_entidad = v_parametros.id_plantilla_entidad;
			
			if (v_estado = 'closed') then
				raise exception 'No es posible modificar la plantilla';
			end if; 
			
			
			update netman.tplantilla_entidad set
			estado = v_parametros.estado,
			tipo_entidad = v_parametros.tipo_entidad,
			nombre = v_parametros.nombre,
			modelo = v_parametros.modelo,
			marca = v_parametros.marca,
			descripcion = v_parametros.descripcion,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario
			where id_plantilla_entidad=v_parametros.id_plantilla_entidad;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Plantilla Entidad modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_plantilla_entidad',v_parametros.id_plantilla_entidad::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;
		
	/*********************************    
 	#TRANSACCION:  'NM_ICOUPLANENT_MOD'
 	#DESCRIPCION:	Modificacion de icono en plantilla
 	#AUTOR:		admin	
 	#FECHA:		16-12-2013 17:20:55
	***********************************/

	elsif(p_transaccion='NM_ICOUPLANENT_MOD')then

		begin
			--Sentencia de la modificacion
			select estado into v_estado
			from netman.tplantilla_entidad
			where id_plantilla_entidad = v_parametros.id_plantilla_entidad;
			
			if (v_estado = 'closed') then
				raise exception 'No es posible modificar la plantilla';
			end if; 
			
			update netman.tplantilla_entidad set
			icono = v_parametros.extension_archivo,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario
			where id_plantilla_entidad=v_parametros.id_plantilla_entidad;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Plantilla Entidad modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_plantilla_entidad',v_parametros.id_plantilla_entidad::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	
	/*********************************    
 	#TRANSACCION:  'NM_PLAENARB_ELI'
 	#DESCRIPCION:	Eliminacion de registros de estructura_plantilla
 	#AUTOR:		admin	
 	#FECHA:		16-12-2013 17:20:55
	***********************************/

	elsif(p_transaccion='NM_PLAENARB_ELI')then

		begin
			--Sentencia de la eliminacion
			
			select estado into v_estado
			from netman.testructura_plantilla esp 
			inner join netman.tplantilla_entidad plaen on plaen.id_plantilla_entidad = esp.id_plantilla_padre
			where esp.id_estructura_plantilla = v_parametros.id_estructura_plantilla;
			
			if (v_estado = 'closed') then
				raise exception 'No es posible eliminar la composicion de la plantilla';
			end if; 
			
			
			delete from netman.testructura_plantilla
            where id_estructura_plantilla=v_parametros.id_estructura_plantilla;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Estructura Entidad eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_estructura_plantilla',v_parametros.id_estructura_plantilla::varchar);
              
            --Devuelve la respuesta
            return v_resp;

		end;
	/*********************************    
 	#TRANSACCION:  'NM_PLAEN_ELI'
 	#DESCRIPCION:	Eliminacion de registros de plantilla
 	#AUTOR:		admin	
 	#FECHA:		16-12-2013 17:20:55
	***********************************/

	elsif(p_transaccion='NM_PLAEN_ELI')then

		begin
			--Sentencia de la eliminacion
			
			select estado into v_estado
			from netman.tplantilla_entidad
			where id_plantilla_entidad = v_parametros.id_plantilla;
			
			if (v_estado = 'closed') then
				raise exception 'No es posible eliminar la composicion de la plantilla';
			end if; 
			
			
			delete from netman.tplantilla_entidad
            where id_plantilla_entidad=v_parametros.id_plantilla_entidad;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Estructura Entidad eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_plantilla_entidad',v_parametros.id_plantilla_entidad::varchar);
              
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
ALTER FUNCTION "netman"."ft_plantilla_entidad_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
