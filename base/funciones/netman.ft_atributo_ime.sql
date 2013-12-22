CREATE OR REPLACE FUNCTION "netman"."ft_atributo_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Network Manager
 FUNCION: 		netman.ft_atributo_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'netman.tatributo'
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
	v_id_atributo	integer;
	v_estado				varchar;
			    
BEGIN

    v_nombre_funcion = 'netman.ft_atributo_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	
	/*********************************    
 	#TRANSACCION:  'NM_ATRI_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		16-12-2013 18:42:43
	***********************************/

	if(p_transaccion='NM_ATRI_MOD')then

		begin
				
			
			--Sentencia de la modificacion
			update netman.tatributo set
			valor = v_parametros.valor
			where id_atributo=v_parametros.id_atributo;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Plantilla Atributo modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_atributo',v_parametros.id_atributo::varchar);
               
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
ALTER FUNCTION "netman"."ft_atributo_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
