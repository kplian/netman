/***********************************I-SCP-JRR-NETMAN-1-16/12/2013****************************************/
CREATE TABLE netman.tplantilla_entidad (
    id_plantilla_entidad serial NOT NULL,
    nombre varchar(100) NOT NULL,
    marca varchar(80),
    modelo varchar(80),
    icono varchar(200),
    descripcion text NOT NULL,
    tipo_entidad varchar(20) NOT NULL,
    estado varchar(10) DEFAULT 'open'::character varying
)
INHERITS (pxp.tbase) WITHOUT OIDS;
ALTER TABLE ONLY netman.tplantilla_entidad ALTER COLUMN id_plantilla_entidad SET STATISTICS 0;
ALTER TABLE ONLY netman.tplantilla_entidad ALTER COLUMN nombre SET STATISTICS 0;
ALTER TABLE ONLY netman.tplantilla_entidad ALTER COLUMN marca SET STATISTICS 0;
ALTER TABLE ONLY netman.tplantilla_entidad ALTER COLUMN modelo SET STATISTICS 0;

CREATE TABLE netman.tplantilla_atributo (
    id_plantilla_atributo serial NOT NULL,
    nombre varchar(100) NOT NULL,
    descripcion text,
    id_plantilla_entidad integer NOT NULL
)
INHERITS (pxp.tbase) WITHOUT OIDS;
ALTER TABLE ONLY netman.tplantilla_atributo ALTER COLUMN id_plantilla_atributo SET STATISTICS 0;
ALTER TABLE ONLY netman.tplantilla_atributo ALTER COLUMN nombre SET STATISTICS 0;
ALTER TABLE ONLY netman.tplantilla_atributo ALTER COLUMN descripcion SET STATISTICS 0;


CREATE TABLE netman.testructura_plantilla (
    id_estructura_plantilla serial NOT NULL,
    id_plantilla_padre integer NOT NULL,
    id_plantilla_hijo integer NOT NULL
)
INHERITS (pxp.tbase) WITHOUT OIDS;
ALTER TABLE ONLY netman.testructura_plantilla ALTER COLUMN id_plantilla_padre SET STATISTICS 0;
ALTER TABLE ONLY netman.testructura_plantilla ALTER COLUMN id_plantilla_hijo SET STATISTICS 0;



CREATE TABLE netman.tentidad (
    id_entidad serial NOT NULL,
    codigo varchar(20),
    codigo_af varchar(20),
    observaciones text,
    id_plantilla_entidad integer,
    id_entidad_relacion integer
)
INHERITS (pxp.tbase) WITHOUT OIDS;
ALTER TABLE ONLY netman.tentidad ALTER COLUMN id_entidad SET STATISTICS 0;
ALTER TABLE ONLY netman.tentidad ALTER COLUMN codigo SET STATISTICS 0;
ALTER TABLE ONLY netman.tentidad ALTER COLUMN codigo_af SET STATISTICS 0;
ALTER TABLE ONLY netman.tentidad ALTER COLUMN observaciones SET STATISTICS 0;
ALTER TABLE ONLY netman.tentidad ALTER COLUMN id_plantilla_entidad SET STATISTICS 0;



CREATE TABLE netman.testructura_entidad (
    id_estructura_entidad serial NOT NULL,
    id_entidad_padre integer NOT NULL,
    id_entidad_hijo integer NOT NULL
)
INHERITS (pxp.tbase) WITHOUT OIDS;
ALTER TABLE ONLY netman.testructura_entidad ALTER COLUMN id_entidad_padre SET STATISTICS 0;
ALTER TABLE ONLY netman.testructura_entidad ALTER COLUMN id_entidad_hijo SET STATISTICS 0;




CREATE TABLE netman.tatributo (
    id_atributo serial NOT NULL,
    valor text,
    id_plantilla_atributo integer NOT NULL,
    id_entidad integer NOT NULL
)
INHERITS (pxp.tbase) WITHOUT OIDS;




CREATE TABLE netman.tarchivo (
    id_archivo serial NOT NULL,
    nombre_doc varchar(200) NOT NULL,
    nombre_arch_doc varchar(200),
    extension varchar(15),
    id_entidad integer
)
INHERITS (pxp.tbase) WITHOUT OIDS;
ALTER TABLE ONLY netman.tarchivo ALTER COLUMN nombre_doc SET STATISTICS 0;


ALTER TABLE ONLY netman.tplantilla_entidad
    ADD CONSTRAINT plantilla_entidad_pkey
    PRIMARY KEY (id_plantilla_entidad);
    
ALTER TABLE ONLY netman.tentidad
    ADD CONSTRAINT entidad_pkey
    PRIMARY KEY (id_entidad);
--
-- Definition for index plantilla_atributo_pkey (OID = 1860372) : 
--
ALTER TABLE ONLY netman.tplantilla_atributo
    ADD CONSTRAINT plantilla_atributo_pkey
    PRIMARY KEY (id_plantilla_atributo);
       
ALTER TABLE ONLY netman.testructura_plantilla
    ADD CONSTRAINT nm_estructura_plantilla_pkey
    PRIMARY KEY (id_estructura_plantilla);
    
ALTER TABLE ONLY netman.testructura_entidad
    ADD CONSTRAINT nm_estructura_entidad_pkey
    PRIMARY KEY (id_estructura_entidad);
    
    
ALTER TABLE ONLY netman.tatributo
    ADD CONSTRAINT tatributo_pkey
    PRIMARY KEY (id_atributo);

ALTER TABLE ONLY netman.tarchivo
    ADD CONSTRAINT tarchivo_pkey
    PRIMARY KEY (id_archivo);

COMMENT ON COLUMN netman.tplantilla_entidad.tipo_entidad IS 'port|equipment|campus|building|rack';
COMMENT ON COLUMN netman.tplantilla_entidad.estado IS 'open|closed';

ALTER TABLE netman.tarchivo
  ADD COLUMN id_plantilla_entidad INTEGER;

ALTER TABLE netman.testructura_entidad
  ADD COLUMN descripcion VARCHAR(200) NOT NULL;
  
ALTER TABLE netman.testructura_plantilla
  ADD COLUMN descripcion VARCHAR(200) NOT NULL;
  
ALTER TABLE netman.tentidad
  ADD COLUMN nombre VARCHAR(100) NOT NULL;
  
ALTER TABLE netman.tentidad
  ADD COLUMN eliminable VARCHAR(2) NOT NULL;


/***********************************F-SCP-JRR-NETMAN-1-16/12/2013****************************************/
