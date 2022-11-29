<?php

class KanbanView extends TPage
{
    private static $database = 'gestao';
    private static $activeRecord = 'KanbanItem';
    private static $primaryKey = 'id';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        try
        {
            parent::__construct();

            $kanban = new TKanban;
            $kanban->setItemDatabase(self::$database);

            $criteriaStage = new TCriteria();
            $criteriaItem = new TCriteria();

            $criteriaStage->setProperty('order', 'estagio_ordem asc');
            $criteriaItem->setProperty('order', 'item_ordem asc');

            if(!$param['projeto_id']) {
                new TMessage('error', "Projeto não informado!");
            }

            $criteriaStage->add(new TFilter('projeto_id', '=', $param['projeto_id']));

            TTransaction::open(self::$database);
            $stages = KanbanEstagio::getObjects($criteriaStage);
            $items  = KanbanItem::getObjects($criteriaItem);

            if($stages)
            {
                foreach ($stages as $key => $stage)
                {

                    $kanban->addStage($stage->id, "{titulo}", $stage);

                }    
            }

            if($items)
            {
                foreach ($items as $key => $item)
                {

                    $kanban->addItem($item->id, $item->estagio_id, "{titulo}", " {status->titulo} ", $item->status->cor, $item);

                }    
            }

            $kanbanStageAction_KanbanEstagioForm_onEdit = new TAction(['KanbanEstagioForm', 'onEdit']);
            $kanbanStageAction_KanbanEstagioForm_onEdit->setParameter("projeto_id", "{$param['projeto_id']}");

            $kanban->addStageAction("Editar Estágio", $kanbanStageAction_KanbanEstagioForm_onEdit, 'fas:edit #03A9F4');
            $kanbanStageAction_KanbanEstagioForm_onShow = new TAction(['KanbanEstagioForm', 'onShow']);
            $kanbanStageAction_KanbanEstagioForm_onShow->setParameter("projeto_id", "{$param['projeto_id']}");

            $kanban->addStageAction("Novo Estágio", $kanbanStageAction_KanbanEstagioForm_onShow, 'fas:plus #8BC34A');
            $kanbanStageAction_KanbanView_onDeleteEstagio = new TAction(['KanbanView', 'onDeleteEstagio']);
            $kanbanStageAction_KanbanView_onDeleteEstagio->setParameter("projeto_id", "{$param['projeto_id']}");

            $kanban->addStageAction("Deletar Estágio", $kanbanStageAction_KanbanView_onDeleteEstagio, 'fas:trash-alt #F44336');

            $kanbanStageShortcut_KanbanItemForm_onShow = new TAction(['KanbanItemForm', 'onShow']);
            $kanbanStageShortcut_KanbanItemForm_onShow->setParameter("projeto_id", "{$param['projeto_id']}");

            $kanban->addStageShortcut("Nova Tarefa", $kanbanStageShortcut_KanbanItemForm_onShow, 'fas:tasks #4CAF50');

            $kanbanItemAction_KanbanItemForm_onEdit = new TAction(['KanbanItemForm', 'onEdit']);

            $kanban->addItemAction("Editar Tarefa", $kanbanItemAction_KanbanItemForm_onEdit, 'fas:edit #03A9F4');
            $kanbanItemAction_KanbanView_onDeleteTarefa = new TAction(['KanbanView', 'onDeleteTarefa']);
            $kanbanItemAction_KanbanView_onDeleteTarefa->setParameter("projeto_id", "{$param['projeto_id']}");

            $kanban->addItemAction("Deletar Tarefa", $kanbanItemAction_KanbanView_onDeleteTarefa, 'fas:trash-alt #F44336');

            //$kanban->setTemplatePath('app/resources/card.html');

            $kanban->setItemDropAction(new TAction([__CLASS__, 'onUpdateItemDrop']));
            $kanban->setStageDropAction(new TAction([__CLASS__, 'onUpdateStageDrop']));
            TTransaction::close();

            $container = new TVBox;

            $container->style = 'width: 100%';
            $container->class = 'form-container';
            if(empty($param['target_container']))
            {
                $container->add(TBreadCrumb::create(["Básico","Kanban"]));
            }
            $container->add($kanban);

            parent::add($container);
        }
        catch(Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

    public function onDeleteTarefa($param = null) 
    {
        if(isset($param['delete']) && $param['delete'] == 1)
        {
            try 
            {
                $key = $param['key'];
                TTransaction::open(self::$database);

                $object = new KanbanItem($key, FALSE);

                $object->delete();

                // Deletar todos os possiveis filhos da Tarefa. Arquivos, Comentarios, etc.

                TTransaction::close();

                TToast::show("success", "Tarefa deletada com sucesso!", "topRight", "fasfa-check");

                TScript::create("$(\"div[item_id='{$key}']\").remove();");
            //</autoCode>
            }
            catch (Exception $e) 
            {
                // shows the exception error message
                new TMessage('error', $e->getMessage());    

                // undo all pending operations
                TTransaction::rollback();
            }
        }
        else
        {
            // define the delete action
            $action = new TAction([$this, 'onDeleteTarefa']);
            $action->setParameters($param);
            $action->setParameter('delete', 1);
            //shows a dialog to the user
            new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);

        }
    }
    public function onDeleteEstagio($param = null) 
    {
        if(isset($param['delete']) && $param['delete'] == 1)
        {
            try 
            {
                $key = $param['key'];
                TTransaction::open(self::$database);

                $object = new KanbanEstagio($key, FALSE);

                $object->delete();

                // Deletar todos os possiveis filhos do Estágio. Tarefas, comentarios, etc..

                TTransaction::close();

                TToast::show("success", "Estágio deletado com sucesso!", "topRight", "fasfa-check");

                TScript::create("$(\"div[stage_id='{$key}']\").remove();");
            //</autoCode>
            }
            catch (Exception $e) 
            {
                // shows the exception error message
                new TMessage('error', $e->getMessage());    

                // undo all pending operations
                TTransaction::rollback();
            }
        }
        else
        {
            // define the delete action
            $action = new TAction([$this, 'onDeleteEstagio']);
            $action->setParameters($param);
            $action->setParameter('delete', 1);
            //shows a dialog to the user
            new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);

        }
    }

    public static function onUpdateStageDrop($param)
    {
        try
        {
            TTransaction::open(self::$database);

            if (!empty($param['order']))
            {
                foreach ($param['order'] as $key => $id)
                {
                    $sequence = ++ $key;

                    $stage = new KanbanEstagio($id);
                    $stage->estagio_ordem = $sequence;

                    $stage->store();

                }
            }
            TTransaction::close();
        }
        catch (Exception $e)
        {
            TTransaction::rollback();
            new TMessage('error', $e->getMessage());
        }
    }
    /**
     * Update item on drop
     */
    public static function onUpdateItemDrop($param)
    {
        try
        {
            TTransaction::open(self::$database);

            if (!empty($param['order']))
            {
                foreach ($param['order'] as $key => $id)
                {
                    $sequence = ++$key;

                    $item = new KanbanItem($id);
                    $item->item_ordem = $sequence;
                    $item->estagio_id = $param['stage_id'];

                    $item->store();

                    if($id == $param['key'])
                    {
                        TScript::create("$(\"div[item_id='{$param['key']}']\").css('border-top', '3px solid {$item->status->cor}');");
                    }

                    // Notifica os usuários da alteração de data do projeto.
                    $msg = "🔄️";
                    $msg .= "*Estágio da tarefa foi alterada.*\n*Estágio:* {estagio->titulo}\n*Tarefa:* {titulo}\n*Projeto:* {projeto->titulo}\n*Início:* {datahora_inicio_br}\n*Término:* {datahora_fim_br} _({tempo_percorrido})_";
                    NotificacaoService::notificar($msg, $item);
                }

                TTransaction::close();
            }
        }
        catch (Exception $e)
        {
            TTransaction::rollback();
            new TMessage('error', $e->getMessage());
        }
    }
    public function onShow($param = null)
    {

    } 

}

