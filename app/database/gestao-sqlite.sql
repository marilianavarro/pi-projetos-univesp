PRAGMA foreign_keys=OFF; 

CREATE TABLE kanban_estagio( 
      id  INTEGER    NOT NULL  , 
      projeto_id int   , 
      titulo varchar  (200)   , 
      estagio_ordem int   , 
      datahora_criacao datetime   , 
      datahora_excluido datetime   , 
      datahora_atualizacao datetime   , 
 PRIMARY KEY (id),
FOREIGN KEY(projeto_id) REFERENCES projeto(id)) ; 

CREATE TABLE kanban_item( 
      id  INTEGER    NOT NULL  , 
      projeto_id int   , 
      estagio_id int   , 
      usuario_id int   , 
      status_id int   , 
      titulo varchar  (200)   , 
      descricao text   , 
      item_ordem int   , 
      datahora_inicio datetime   , 
      datahora_fim datetime   , 
      datahora_criacao datetime   , 
      datahora_excluido datetime   , 
      datahora_atualizacao datetime   , 
 PRIMARY KEY (id),
FOREIGN KEY(projeto_id) REFERENCES projeto(id),
FOREIGN KEY(usuario_id) REFERENCES system_users(id),
FOREIGN KEY(status_id) REFERENCES status(id),
FOREIGN KEY(estagio_id) REFERENCES kanban_estagio(id)) ; 

CREATE TABLE log_eventos( 
      id  INTEGER    NOT NULL  , 
      estagio_id int   , 
      projeto_id int   , 
      usuario_id int   , 
      mensagem text   , 
      datahora_criacao datetime   , 
      datahora_excluido datetime   , 
      datahora_atualizacao datetime   , 
 PRIMARY KEY (id),
FOREIGN KEY(estagio_id) REFERENCES kanban_estagio(id),
FOREIGN KEY(projeto_id) REFERENCES projeto(id),
FOREIGN KEY(usuario_id) REFERENCES system_users(id)) ; 

CREATE TABLE projeto( 
      id  INTEGER    NOT NULL  , 
      titulo varchar  (200)   , 
      datahora_criacao datetime   , 
      datahora_excluido datetime   , 
      datahora_atualizacao datetime   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE status( 
      id  INTEGER    NOT NULL  , 
      titulo varchar  (200)   , 
      cor text   , 
      datahora_criacao datetime   , 
      datahora_excluido datetime   , 
      datahora_atualizacao datetime   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group( 
      id int   NOT NULL  , 
      name text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_program_id) REFERENCES system_program(id),
FOREIGN KEY(system_group_id) REFERENCES system_group(id)) ; 

CREATE TABLE system_preference( 
      id varchar  (255)   NOT NULL  , 
      preference text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id int   NOT NULL  , 
      name text   NOT NULL  , 
      controller text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id int   NOT NULL  , 
      name text   NOT NULL  , 
      connection_name text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_group_id) REFERENCES system_group(id),
FOREIGN KEY(system_user_id) REFERENCES system_users(id)) ; 

CREATE TABLE system_user_program( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_program_id) REFERENCES system_program(id),
FOREIGN KEY(system_user_id) REFERENCES system_users(id)) ; 

CREATE TABLE system_users( 
      id int   NOT NULL  , 
      name text   NOT NULL  , 
      login text   NOT NULL  , 
      password text   NOT NULL  , 
      email text   , 
      frontpage_id int   , 
      system_unit_id int   , 
      active char  (1)   , 
      accepted_term_policy_at text   , 
      accepted_term_policy char  (1)   , 
 PRIMARY KEY (id),
FOREIGN KEY(system_unit_id) REFERENCES system_unit(id),
FOREIGN KEY(frontpage_id) REFERENCES system_program(id)) ; 

CREATE TABLE system_user_unit( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_unit_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_user_id) REFERENCES system_users(id),
FOREIGN KEY(system_unit_id) REFERENCES system_unit(id)) ; 

 
 
  
