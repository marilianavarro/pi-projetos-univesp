<?php

class CronService
{
    public static function notificarAtrasos()
    {
        date_default_timezone_set('America/Sao_Paulo');
        TTransaction::open('gestao');
        $repository = new TRepository('KanbanItem');
        $criteria = new TCriteria;
    
        // Filtros
        $criteria->add(new TFilter('datahora_fim', '<', 'NOW()'));
        $criteria->add(new TFilter('status_id', 'NOT IN', [Status::Finalizado, Status::Cancelado]));
        //var_dump($criteria->dump());
        
        $objs = $repository->load($criteria);
        //var_dump($repository->count($criteria));
        
        foreach($objs as $obj)
        {
            
            $template_msg = "⚠️ *TAREFA ATRASADA!*\n*Tarefa:* {titulo}\n*Usuário:* {usuario->name}\n*Projeto:* {projeto->titulo}\n*Data Término:*  {datahora_fim_br} _({tempo_percorrido})_";

            NotificacaoService::notificar($template_msg, $obj);
        }
        
        TTransaction::close();
    }
}
