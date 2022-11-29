<?php

class KanbanItemCalendarForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'gestao';
    private static $activeRecord = 'KanbanItem';
    private static $primaryKey = 'id';
    private static $formName = 'form_KanbanItemCalendarForm';
    private static $startDateField = 'datahora_inicio';
    private static $endDateField = 'datahora_fim';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Calendário");

        $view = new THidden('view');

        $datahora_inicio = new TDateTime('datahora_inicio');
        $datahora_fim = new TDateTime('datahora_fim');
        $projeto_id = new TDBCombo('projeto_id', 'gestao', 'Projeto', 'id', '{titulo}','titulo asc'  );
        $id = new THidden('id');
        $item_ordem = new THidden('item_ordem');
        $estagio_id = new TDBCombo('estagio_id', 'gestao', 'KanbanEstagio', 'id', '{titulo}','titulo asc'  );
        $usuario_id = new TDBCombo('usuario_id', 'gestao', 'SystemUsers', 'id', '{name}','name asc'  );
        $status_id = new TDBCombo('status_id', 'gestao', 'Status', 'id', '{titulo}','titulo asc'  );
        $titulo = new TEntry('titulo');
        $descricao = new THtmlEditor('descricao');

        $projeto_id->addValidation("Projeto obrigatório!", new TRequiredValidator()); 
        $estagio_id->addValidation("Estágio Obrigatório!", new TRequiredValidator()); 
        $status_id->addValidation("Status Obrigatório", new TRequiredValidator()); 

        $titulo->setMaxLength(200);
        $datahora_fim->setMask('dd/mm/yyyy hh:ii');
        $datahora_inicio->setMask('dd/mm/yyyy hh:ii');

        $datahora_fim->setDatabaseMask('yyyy-mm-dd hh:ii');
        $datahora_inicio->setDatabaseMask('yyyy-mm-dd hh:ii');

        $status_id->setValue(Status::EmAndamento);
        $usuario_id->setValue(TSession::getValue("userid"));

        $status_id->enableSearch();
        $projeto_id->enableSearch();
        $estagio_id->enableSearch();
        $usuario_id->enableSearch();

        $id->setSize(200);
        $titulo->setSize('100%');
        $item_ordem->setSize(200);
        $datahora_fim->setSize(150);
        $status_id->setSize('100%');
        $projeto_id->setSize('100%');
        $estagio_id->setSize('100%');
        $usuario_id->setSize('100%');
        $datahora_inicio->setSize(150);
        $descricao->setSize('100%', 210);

        $row1 = $this->form->addFields([new TLabel("Data Início:", null, '14px', null, '100%'),$datahora_inicio],[new TLabel("Data Fim:", null, '14px', null, '100%'),$datahora_fim]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Projeto:", null, '14px', null, '100%'),$projeto_id,$id,$item_ordem]);
        $row2->layout = ['col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("Estágio:", null, '14px', null, '100%'),$estagio_id],[new TLabel("Usuário:", null, '14px', null, '100%'),$usuario_id]);
        $row3->layout = ['col-sm-6','col-sm-6'];

        $row4 = $this->form->addFields([new TLabel("Status:", null, '14px', null, '100%'),$status_id],[new TLabel("Título:", null, '14px', null, '100%'),$titulo]);
        $row4->layout = ['col-sm-6','col-sm-6'];

        $row5 = $this->form->addFields([new TLabel("Descrição:", null, '14px', null, '100%'),$descricao]);
        $row5->layout = [' col-sm-12'];

        $this->form->addFields([$view]);

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_ondelete = $this->form->addAction("Excluir", new TAction([$this, 'onDelete']), 'fas:trash-alt #dd5a43');
        $this->btn_ondelete = $btn_ondelete;

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data
            $data = $this->form->getData(); // get form data as array

            $datahora_inicio = strtotime($data->datahora_inicio);
            $datahora_fim = strtotime($data->datahora_fim);

            if ($datahora_inicio > $datahora_fim)
            {
                throw new Exception('A Data Término deve ser maior que a data início');
            }

            $object = new KanbanItem(); // create an empty object 

            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $messageAction = new TAction(['KanbanItemCalendarFormView', 'onReload']);
            $messageAction->setParameter('view', $data->view);
            $messageAction->setParameter('date', explode(' ', $data->datahora_inicio)[0]);

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

                        TScript::create("Template.closeRightPanel();"); 

        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> 

            TTransaction::rollback(); // undo all pending operations
            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
        }
    }
    public function onDelete($param = null) 
    {
        if(isset($param['delete']) && $param['delete'] == 1)
        {
            try
            {
                $key = $param[self::$primaryKey];

                // open a transaction with database
                TTransaction::open(self::$database);

                $class = self::$activeRecord;

                // instantiates object
                $object = new $class($key, FALSE);

                // deletes the object from the database
                $object->delete();

                // close the transaction
                TTransaction::close();

                $messageAction = new TAction(array(__CLASS__.'View', 'onReload'));
                $messageAction->setParameter('view', $param['view']);
                $messageAction->setParameter('date', explode(' ',$param[self::$startDateField])[0]);

                // shows the success message
                new TMessage('info', AdiantiCoreTranslator::translate('Record deleted'), $messageAction);
            }
            catch (Exception $e) // in case of exception
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
            $action = new TAction(array($this, 'onDelete'));
            $action->setParameters((array) $this->form->getData());
            $action->setParameter('delete', 1);
            // shows a dialog to the user
            new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);   
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new KanbanItem($key); // instantiates the Active Record 

                                $object->view = !empty($param['view']) ? $param['view'] : 'agendaWeek'; 

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    } 

    public function onStartEdit($param)
    {

        $this->form->clear(true);

        $data = new stdClass;
        $data->view = $param['view'] ?? 'week'; // calendar view
        $data->status = new stdClass();
        $data->status->cor = '#3a87ad';

        if (!empty($param['date']))
        {
            if(strlen($param['date']) == '10')
                $param['date'].= ' 09:00';

            $data->datahora_inicio = str_replace('T', ' ', $param['date']);

            $datahora_fim = new DateTime($data->datahora_inicio);
            $datahora_fim->add(new DateInterval('PT1H'));
            $data->datahora_fim = $datahora_fim->format('Y-m-d H:i:s');

        }

        $this->form->setData( $data );
    }

    public static function onUpdateEvent($param)
    {
        try
        {
            if (isset($param['id']))
            {
                TTransaction::open(self::$database);

                $class = self::$activeRecord;
                $object = new $class($param['id']);

                $object->datahora_inicio = str_replace('T', ' ', $param['start_time']);
                $object->datahora_fim   = str_replace('T', ' ', $param['end_time']);

                // Notifica os usuários da alteração de data do projeto.
                $msg = "🔄️*Data da tarefa do projeto foi alterada.*\n*Tarefa:* {titulo}\n*Projeto:* {projeto->titulo}\n*Início:* {datahora_inicio_br}\n*Término:* {datahora_fim_br} _({tempo_percorrido})_";
                NotificacaoService::notificar($msg, $object);

                $object->store();

                // close the transaction
                TTransaction::close();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', '<b>Error</b> ' . $e->getMessage());
            TTransaction::rollback();
        }
    }

}

