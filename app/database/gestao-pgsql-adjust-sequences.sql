SELECT setval('kanban_estagio_id_seq', coalesce(max(id),0) + 1, false) FROM kanban_estagio;
SELECT setval('kanban_item_id_seq', coalesce(max(id),0) + 1, false) FROM kanban_item;
SELECT setval('log_eventos_id_seq', coalesce(max(id),0) + 1, false) FROM log_eventos;
SELECT setval('notificacao_id_seq', coalesce(max(id),0) + 1, false) FROM notificacao;
SELECT setval('projeto_id_seq', coalesce(max(id),0) + 1, false) FROM projeto;
SELECT setval('status_id_seq', coalesce(max(id),0) + 1, false) FROM status;