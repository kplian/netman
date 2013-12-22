/***********************************I-DAT-JRR-NETMAN-0-16/12/2013****************************************/

INSERT INTO segu.tsubsistema ( codigo, nombre, fecha_reg, prefijo, estado_reg, nombre_carpeta, id_subsis_orig)
VALUES ('NETMAN', 'Network Manager', '2013-12-16', 'NM', 'activo', 'netman', NULL);
 
 select pxp.f_insert_tgui ('NETWORK MANAGER', '', 'NETMAN', 'si' ,0 , '', 1, '', '', 'NETMAN'); 
 select pxp.f_insert_tgui ('Plantillas', 'Plantilla Entidad', 'PLANTENT', 'si', 1, 'sis_netman/vista/plantilla_entidad/PlantillaEntidad.php', 2, '', 'PlantillaEntidad', 'NETMAN'); 
 select pxp.f_insert_tgui ('Infraestructura de Red', 'Infraestructura de Red', 'ENTID', 'si', 2, 'sis_netman/vista/entidad/EntidadArb.php', 2, '', 'EntidadArb', 'NETMAN'); 
 select pxp.f_insert_testructura_gui ('NETMAN', 'SISTEMA'); select pxp.f_insert_testructura_gui ('PLANTENT', 'NETMAN'); 
 select pxp.f_insert_testructura_gui ('ENTID', 'NETMAN');
 
 
INSERT INTO netman.tentidad ("id_entidad", "codigo", "codigo_af", "observaciones", "id_plantilla_entidad", "nombre", "eliminable")
VALUES ( 0, 'ENT', NULL, NULL, NULL, 'Raiz Infraestructura de Red', 'no');
 
/***********************************F-DAT-JRR-NETMAN-0-16/12/2013****************************************/