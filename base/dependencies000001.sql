/***********************************I-DEP-JRR-NETMAN-1-16/12/2013****************************************/

ALTER TABLE ONLY netman.tplantilla_atributo
    ADD CONSTRAINT fk__plantilla_atributo__id_plantilla_entidad
    FOREIGN KEY (id_plantilla_entidad) REFERENCES netman.tplantilla_entidad(id_plantilla_entidad);

ALTER TABLE ONLY netman.testructura_plantilla
    ADD CONSTRAINT fk__nm_estructura_plantilla__id_plantilla_padre
    FOREIGN KEY (id_plantilla_padre) REFERENCES netman.tplantilla_entidad(id_plantilla_entidad);

ALTER TABLE ONLY netman.testructura_plantilla
    ADD CONSTRAINT fk__nm_estructura_plantilla__id_plantilla_hijo
    FOREIGN KEY (id_plantilla_hijo) REFERENCES netman.tplantilla_entidad(id_plantilla_entidad);

ALTER TABLE ONLY netman.tentidad
    ADD CONSTRAINT fk__nm_entidad__id_plantilla_entidad
    FOREIGN KEY (id_plantilla_entidad) REFERENCES netman.tplantilla_entidad(id_plantilla_entidad);

ALTER TABLE ONLY netman.testructura_entidad
    ADD CONSTRAINT fk__nm_estructura_entidad__id_entidad_hijo
    FOREIGN KEY (id_entidad_hijo) REFERENCES netman.tentidad(id_entidad);

ALTER TABLE ONLY netman.testructura_entidad
    ADD CONSTRAINT fk__nm_estructura_entidad__id_entidad_padre
    FOREIGN KEY (id_entidad_padre) REFERENCES netman.tentidad(id_entidad);

ALTER TABLE ONLY netman.tatributo
    ADD CONSTRAINT fk__tatributo__id_plantilla_atributo
    FOREIGN KEY (id_plantilla_atributo) REFERENCES netman.tplantilla_atributo(id_plantilla_atributo);

ALTER TABLE ONLY netman.tatributo
    ADD CONSTRAINT fk__tatributo_id_entidad
    FOREIGN KEY (id_entidad) REFERENCES netman.tentidad(id_entidad);

ALTER TABLE ONLY netman.tarchivo
    ADD CONSTRAINT fk__tarchivo__id_entidad
    FOREIGN KEY (id_entidad) REFERENCES netman.tentidad(id_entidad);
    
ALTER TABLE netman.tarchivo
  ADD CONSTRAINT fk__tarchivo__id_plantilla_entidad FOREIGN KEY (id_plantilla_entidad)
    REFERENCES netman.tplantilla_entidad(id_plantilla_entidad)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
ALTER TABLE netman.tentidad
  ADD CONSTRAINT fk__tentidad__id_entidad_relacion FOREIGN KEY (id_entidad_relacion)
    REFERENCES netman.tentidad(id_entidad)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;


/***********************************F-DEP-JRR-NETMAN-1-16/12/2013****************************************/