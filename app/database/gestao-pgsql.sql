CREATE TABLE kanban_estagio( 
      id  SERIAL    NOT NULL  , 
      projeto_id integer   , 
      titulo varchar  (200)   , 
      estagio_ordem integer   , 
      datahora_criacao timestamp   , 
      datahora_excluido timestamp   , 
      datahora_atualizacao timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE kanban_item( 
      id  SERIAL    NOT NULL  , 
      projeto_id integer   , 
      estagio_id integer   , 
      usuario_id integer   , 
      status_id integer   , 
      titulo varchar  (200)   , 
      descricao text   , 
      item_ordem integer   , 
      datahora_inicio timestamp   , 
      datahora_fim timestamp   , 
      datahora_criacao timestamp   , 
      datahora_excluido timestamp   , 
      datahora_atualizacao timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE log_eventos( 
      id  SERIAL    NOT NULL  , 
      estagio_id integer   , 
      projeto_id integer   , 
      usuario_id integer   , 
      mensagem text   , 
      datahora_criacao timestamp   , 
      datahora_excluido timestamp   , 
      datahora_atualizacao timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE projeto( 
      id  SERIAL    NOT NULL  , 
      titulo varchar  (200)   , 
      datahora_criacao timestamp   , 
      datahora_excluido timestamp   , 
      datahora_atualizacao timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE status( 
      id  SERIAL    NOT NULL  , 
      titulo varchar  (200)   , 
      cor text   , 
      datahora_criacao timestamp   , 
      datahora_excluido timestamp   , 
      datahora_atualizacao timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group( 
      id integer   NOT NULL  , 
      name text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id integer   NOT NULL  , 
      system_group_id integer   NOT NULL  , 
      system_program_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_preference( 
      id varchar  (255)   NOT NULL  , 
      preference text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id integer   NOT NULL  , 
      name text   NOT NULL  , 
      controller text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id integer   NOT NULL  , 
      name text   NOT NULL  , 
      connection_name text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id integer   NOT NULL  , 
      system_user_id integer   NOT NULL  , 
      system_group_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_program( 
      id integer   NOT NULL  , 
      system_user_id integer   NOT NULL  , 
      system_program_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_users( 
      id integer   NOT NULL  , 
      name text   NOT NULL  , 
      login text   NOT NULL  , 
      password text   NOT NULL  , 
      email text   , 
      frontpage_id integer   , 
      system_unit_id integer   , 
      active char  (1)   , 
      accepted_term_policy_at text   , 
      accepted_term_policy char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_unit( 
      id integer   NOT NULL  , 
      system_user_id integer   NOT NULL  , 
      system_unit_id integer   NOT NULL  , 
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

  
