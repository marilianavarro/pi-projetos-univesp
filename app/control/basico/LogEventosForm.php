<?php

class LogEventosForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'gestao';
    private static $activeRecord = 'LogEventos';
    private static $primaryKey = 'id';
    private static $formName = 'form_LogEventosForm';

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
        $this->form->setFormTitle("Cadastro de log eventos");


        $id = new TEntry('id');
        $estagio_id = new TDBCombo('estagio_id', 'gestao', 'KanbanEstagio', 'id', '{titulo}','titulo asc'  );
        $projeto_id = new TDBCombo('projeto_id', 'gestao', 'Projeto', 'id', '{titulo}','titulo asc'  );
        $usuario_id = new TDBCombo('usuario_id', 'gestao', 'SystemUsers', 'id', '{name}','name asc'  );
        $mensagem = new TEntry('mensagem');
        $datahora_criacao = new TDateTime('datahora_criacao');
        $datahora_excluido = new TDateTime('datahora_excluido');
        $datahora_atualizacao = new TDateTime('datahora_atualizacao');


        $id->setEditable(false);

        $estagio_id->enableSearch();
        $projeto_id->enableSearch();
        $usuario_id->enableSearch();

        $datahora_criacao->setMask('dd/mm/yyyy hh:ii');
        $datahora_excluido->setMask('dd/mm/yyyy hh:ii');
        $datahora_atualizacao->setMask('dd/mm/yyyy hh:ii');

        $datahora_criacao->setDatabaseMask('yyyy-mm-dd hh:ii');
        $datahora_excluido->setDatabaseMask('yyyy-mm-dd hh:ii');
        $datahora_atualizacao->setDatabaseMask('yyyy-mm-dd hh:ii');

        $id->setSize(100);
        $mensagem->setSize('100%');
        $estagio_id->setSize('100%');
        $projeto_id->setSize('100%');
        $usuario_id->setSize('100%');
        $datahora_criacao->setSize(150);
        $datahora_excluido->setSize(150);
        $datahora_atualizacao->setSize(150);

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("Estágio:", null, '14px', null, '100%'),$estagio_id]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Projeto:", null, '14px', null, '100%'),$projeto_id],[new TLabel("Usuário:", null, '14px', null, '100%'),$usuario_id]);
        $row2->layout = ['col-sm-6','col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("Mensagem:", null, '14px', null, '100%'),$mensagem],[new TLabel("Datahora criacao:", null, '14px', null, '100%'),$datahora_criacao]);
        $row3->layout = ['col-sm-6','col-sm-6'];

        $row4 = $this->form->addFields([new TLabel("Datahora excluido:", null, '14px', null, '100%'),$datahora_excluido],[new TLabel("Datahora atualizacao:", null, '14px', null, '100%'),$datahora_atualizacao]);
        $row4->layout = ['col-sm-6','col-sm-6'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['LogEventosHeaderList', 'onShow']), 'fas:arrow-left #000000');
        $this->btn_onshow = $btn_onshow;

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

            $object = new LogEventos(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('LogEventosHeaderList', 'onShow', $loadPageParam); 

                        TScript::create("Template.closeRightPanel();"); 
        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> 

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
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

                $object = new LogEventos($key); // instantiates the Active Record 

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

}

