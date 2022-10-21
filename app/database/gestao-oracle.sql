CREATE TABLE kanban_estagio( 
      id number(10)    NOT NULL , 
      projeto_id number(10)   , 
      titulo varchar  (200)   , 
      estagio_ordem number(10)   , 
      datahora_criacao timestamp(0)   , 
      datahora_excluido timestamp(0)   , 
      datahora_atualizacao timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE kanban_item( 
      id number(10)    NOT NULL , 
      projeto_id number(10)   , 
      estagio_id number(10)   , 
      usuario_id number(10)   , 
      status_id number(10)   , 
      titulo varchar  (200)   , 
      descricao varchar(3000)   , 
      item_ordem number(10)   , 
      datahora_inicio timestamp(0)   , 
      datahora_fim timestamp(0)   , 
      datahora_criacao timestamp(0)   , 
      datahora_excluido timestamp(0)   , 
      datahora_atualizacao timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE log_eventos( 
      id number(10)    NOT NULL , 
      estagio_id number(10)   , 
      projeto_id number(10)   , 
      usuario_id number(10)   , 
      mensagem varchar(3000)   , 
      datahora_criacao timestamp(0)   , 
      datahora_excluido timestamp(0)   , 
      datahora_atualizacao timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE projeto( 
      id number(10)    NOT NULL , 
      titulo varchar  (200)   , 
      datahora_criacao timestamp(0)   , 
      datahora_excluido timestamp(0)   , 
      datahora_atualizacao timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE status( 
      id number(10)    NOT NULL , 
      titulo varchar  (200)   , 
      cor varchar(3000)   , 
      datahora_criacao timestamp(0)   , 
      datahora_excluido timestamp(0)   , 
      datahora_atualizacao timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id number(10)    NOT NULL , 
      system_group_id number(10)    NOT NULL , 
      system_program_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_preference( 
      id varchar  (255)    NOT NULL , 
      preference varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      controller varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      connection_name varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_group_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_program( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_program_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_users( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      login varchar(3000)    NOT NULL , 
      password varchar(3000)    NOT NULL , 
      email varchar(3000)   , 
      frontpage_id number(10)   , 
      system_unit_id number(10)   , 
      active char  (1)   , 
      accepted_term_policy_at varchar(3000)   , 
      accepted_term_policy char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_unit( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_unit_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

 
  
 ALTER TABLE kanban_estagio ADD CONSTRAINT fk_kanban_estagio_1 FOREIGN KEY (projeto_id) references projeto(id); 
ALTER TABLE kanban_item ADD CONSTRAINT fk_kanban_item_1 FOREIGN KEY (projeto_id) references projeto(id); 
ALTER TABLE kanban_item ADD CONSTRAINT fk_kanban_item_2 FOREIGN KEY (usuario_id) references system_users(id); 
ALTER TABLE kanban_item ADD CONSTRAINT fk_kanban_item_3 FOREIGN KEY (status_id) references status(id); 
ALTER TABLE kanban_item ADD CONSTRAINT fk_kanban_item_4 FOREIGN KEY (estagio_id) references kanban_estagio(id); 
ALTER TABLE log_eventos ADD CONSTRAINT fk_log_eventos_1 FOREIGN KEY (estagio_id) references kanban_estagio(id); 
ALTER TABLE log_eventos ADD CONSTRAINT fk_log_eventos_2 FOREIGN KEY (projeto_id) references projeto(id); 
ALTER TABLE log_eventos ADD CONSTRAINT fk_log_eventos_3 FOREIGN KEY (usuario_id) references system_users(id); 
ALTER TABLE system_group_program ADD CONSTRAINT fk_system_group_program_1 FOREIGN KEY (system_program_id) references system_program(id); 
ALTER TABLE system_group_program ADD CONSTRAINT fk_system_group_program_2 FOREIGN KEY (system_group_id) references system_group(id); 
ALTER TABLE system_user_group ADD CONSTRAINT fk_system_user_group_1 FOREIGN KEY (system_group_id) references system_group(id); 
ALTER TABLE system_user_group ADD CONSTRAINT fk_system_user_group_2 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_user_program ADD CONSTRAINT fk_system_user_program_1 FOREIGN KEY (system_program_id) references system_program(id); 
ALTER TABLE system_user_program ADD CONSTRAINT fk_system_user_program_2 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_users ADD CONSTRAINT fk_system_user_1 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE system_users ADD CONSTRAINT fk_system_user_2 FOREIGN KEY (frontpage_id) references system_program(id); 
ALTER TABLE system_user_unit ADD CONSTRAINT fk_system_user_unit_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_user_unit ADD CONSTRAINT fk_system_user_unit_2 FOREIGN KEY (system_unit_id) references system_unit(id); 
 CREATE SEQUENCE kanban_estagio_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER kanban_estagio_id_seq_tr 

BEFORE INSERT ON kanban_estagio FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT kanban_estagio_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE kanban_item_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER kanban_item_id_seq_tr 

BEFORE INSERT ON kanban_item FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT kanban_item_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE log_eventos_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER log_eventos_id_seq_tr 

BEFORE INSERT ON log_eventos FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT log_eventos_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE projeto_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER projeto_id_seq_tr 

BEFORE INSERT ON projeto FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT projeto_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE status_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER status_id_seq_tr 

BEFORE INSERT ON status FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT status_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
 
  
