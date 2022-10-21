CREATE TABLE kanban_estagio( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `projeto_id` int   , 
      `titulo` varchar  (200)   , 
      `estagio_ordem` int   , 
      `datahora_criacao` datetime   , 
      `datahora_excluido` datetime   , 
      `datahora_atualizacao` datetime   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE kanban_item( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `projeto_id` int   , 
      `estagio_id` int   , 
      `usuario_id` int   , 
      `status_id` int   , 
      `titulo` varchar  (200)   , 
      `descricao` text   , 
      `item_ordem` int   , 
      `datahora_inicio` datetime   , 
      `datahora_fim` datetime   , 
      `datahora_criacao` datetime   , 
      `datahora_excluido` datetime   , 
      `datahora_atualizacao` datetime   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE log_eventos( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `estagio_id` int   , 
      `projeto_id` int   , 
      `usuario_id` int   , 
      `mensagem` text   , 
      `datahora_criacao` datetime   , 
      `datahora_excluido` datetime   , 
      `datahora_atualizacao` datetime   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE notificacao( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `telegram_chatid` int   , 
      `telegram_usuario` varchar  (100)   , 
      `datahora_criacao` datetime   , 
      `datahora_excluido` datetime   , 
      `datahora_atualizacao` datetime   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE projeto( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `titulo` varchar  (200)   , 
      `datahora_criacao` datetime   , 
      `datahora_excluido` datetime   , 
      `datahora_atualizacao` datetime   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE status( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `titulo` varchar  (200)   , 
      `cor` text   , 
      `datahora_criacao` datetime   , 
      `datahora_excluido` datetime   , 
      `datahora_atualizacao` datetime   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE system_group( 
      `id` int   NOT NULL  , 
      `name` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE system_group_program( 
      `id` int   NOT NULL  , 
      `system_group_id` int   NOT NULL  , 
      `system_program_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE system_preference( 
      `id` varchar  (255)   NOT NULL  , 
      `preference` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE system_program( 
      `id` int   NOT NULL  , 
      `name` text   NOT NULL  , 
      `controller` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE system_unit( 
      `id` int   NOT NULL  , 
      `name` text   NOT NULL  , 
      `connection_name` text   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE system_user_group( 
      `id` int   NOT NULL  , 
      `system_user_id` int   NOT NULL  , 
      `system_group_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE system_user_program( 
      `id` int   NOT NULL  , 
      `system_user_id` int   NOT NULL  , 
      `system_program_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE system_users( 
      `id` int   NOT NULL  , 
      `name` text   NOT NULL  , 
      `login` text   NOT NULL  , 
      `password` text   NOT NULL  , 
      `email` text   , 
      `frontpage_id` int   , 
      `system_unit_id` int   , 
      `active` char  (1)   , 
      `accepted_term_policy_at` text   , 
      `accepted_term_policy` char  (1)   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE system_user_unit( 
      `id` int   NOT NULL  , 
      `system_user_id` int   NOT NULL  , 
      `system_unit_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

 
  
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

  
