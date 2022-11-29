<?php

class KanbanItemForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'gestao';
    private static $activeRecord = 'KanbanItem';
    private static $primaryKey = 'id';
    private static $formName = 'form_KanbanItemForm';

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
        $this->form->setFormTitle("Cadastro de Tarefas");


        $datahora_inicio = new TDateTime('datahora_inicio');
        $datahora_fim = new TDateTime('datahora_fim');
        $projeto_id = new THidden('projeto_id');
        $estagio_id = new THidden('estagio_id');
        $item_ordem = new THidden('item_ordem');
        $id = new THidden('id');
        $titulo = new TEntry('titulo');
        $descricao = new THtmlEditor('descricao');
        $status_id = new TDBCombo('status_id', 'gestao', 'Status', 'id', '{titulo}','titulo asc'  );
        $usuario_id = new TDBCombo('usuario_id', 'gestao', 'SystemUsers', 'id', '{name}','name asc'  );

        $datahora_inicio->addValidation("Data Início Obrigatória!", new TRequiredValidator()); 
        $datahora_fim->addValidation("Data Término Obrigatória!", new TRequiredValidator()); 
        $titulo->addValidation("Título obrigatório!", new TRequiredValidator()); 
        $status_id->addValidation("Status obrigatório!", new TRequiredValidator()); 

        $titulo->setMaxLength(200);
        $status_id->setDefaultOption(false);

        $datahora_fim->setMask('dd/mm/yyyy hh:ii');
        $datahora_inicio->setMask('dd/mm/yyyy hh:ii');

        $datahora_fim->setDatabaseMask('yyyy-mm-dd hh:ii');
        $datahora_inicio->setDatabaseMask('yyyy-mm-dd hh:ii');

        $status_id->setValue(Status::EmAndamento);
        $usuario_id->setValue(TSession::getValue("userid"));

        $status_id->enableSearch();
        $usuario_id->enableSearch();

        $id->setSize(200);
        $titulo->setSize('100%');
        $projeto_id->setSize(200);
        $estagio_id->setSize(200);
        $item_ordem->setSize(200);
        $datahora_fim->setSize(150);
        $status_id->setSize('100%');
        $usuario_id->setSize('100%');
        $datahora_inicio->setSize(150);
        $descricao->setSize('100%', 180);

        $row1 = $this->form->addFields([new TLabel("Data Início:", null, '14px', 'I', '100%'),$datahora_inicio],[new TLabel("Data Término:", null, '14px', 'I', '100%'),$datahora_fim,$projeto_id,$estagio_id,$item_ordem,$id]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Título:", null, '14px', 'I', '100%'),$titulo]);
        $row2->layout = [' col-sm-12'];

        $row3 = $this->form->addFields([new TLabel("Descrição:", null, '14px', null, '100%'),$descricao]);
        $row3->layout = [' col-sm-12'];

        $row4 = $this->form->addFields([new TLabel("Status:", null, '14px', 'I', '100%'),$status_id],[new TLabel("Usuário Responsável:", null, '14px', null, '100%'),$usuario_id]);
        $row4->layout = [' col-sm-6',' col-sm-6'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

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

            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            $loadPageParam["projeto_id"] = "{$param['projeto_id']}"; 

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Tarefa salva", 'topRight', 'far:check-circle');
            TApplication::loadPage('KanbanView', 'onShow', $loadPageParam); 

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

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new KanbanItem($key); // instantiates the Active Record 

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

        if(!$param['projeto_id']) {
            new TMessage('error', "Projeto não informado!");
        }

        if(!$param['key']) {
            new TMessage('error', "Estágio não informado!");
        }

        $object = new KanbanItem(); // create an empty object

        if (isset($param['projeto_id']))
        {
            $projeto_id = $param['projeto_id'];  // get the parameter $projeto_id
            $object->projeto_id = $projeto_id;
        }

        if (isset($param['key']))
        {
            $estagio_id = $param['key'];  // get the parameter $key
            $object->estagio_id = $estagio_id;
        }

        $this->form->setData($object); // fill the form
    } 

}

