CREATE TABLE kanban_estagio( 
      id  INT IDENTITY    NOT NULL  , 
      projeto_id int   , 
      titulo varchar  (200)   , 
      estagio_ordem int   , 
      datahora_criacao datetime2   , 
      datahora_excluido datetime2   , 
      datahora_atualizacao datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE kanban_item( 
      id  INT IDENTITY    NOT NULL  , 
      projeto_id int   , 
      estagio_id int   , 
      usuario_id int   , 
      status_id int   , 
      titulo varchar  (200)   , 
      descricao nvarchar(max)   , 
      item_ordem int   , 
      datahora_inicio datetime2   , 
      datahora_fim datetime2   , 
      datahora_criacao datetime2   , 
      datahora_excluido datetime2   , 
      datahora_atualizacao datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE log_eventos( 
      id  INT IDENTITY    NOT NULL  , 
      estagio_id int   , 
      projeto_id int   , 
      usuario_id int   , 
      mensagem nvarchar(max)   , 
      datahora_criacao datetime2   , 
      datahora_excluido datetime2   , 
      datahora_atualizacao datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE notificacao( 
      id  INT IDENTITY    NOT NULL  , 
      telegram_chatid int   , 
      telegram_usuario varchar  (100)   , 
      datahora_criacao datetime2   , 
      datahora_excluido datetime2   , 
      datahora_atualizacao datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE projeto( 
      id  INT IDENTITY    NOT NULL  , 
      titulo varchar  (200)   , 
      datahora_criacao datetime2   , 
      datahora_excluido datetime2   , 
      datahora_atualizacao datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE status( 
      id  INT IDENTITY    NOT NULL  , 
      titulo varchar  (200)   , 
      cor nvarchar(max)   , 
      datahora_criacao datetime2   , 
      datahora_excluido datetime2   , 
      datahora_atualizacao datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_preference( 
      id varchar  (255)   NOT NULL  , 
      preference nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      controller nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      connection_name nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_program( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_users( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      login nvarchar(max)   NOT NULL  , 
      password nvarchar(max)   NOT NULL  , 
      email nvarchar(max)   , 
      frontpage_id int   , 
      system_unit_id int   , 
      active char  (1)   , 
      accepted_term_policy_at nvarchar(max)   , 
      accepted_term_policy char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_unit( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_unit_id int   NOT NULL  , 
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

  
