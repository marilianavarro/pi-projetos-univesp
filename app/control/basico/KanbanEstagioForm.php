<?php

class KanbanEstagioForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'gestao';
    private static $activeRecord = 'KanbanEstagio';
    private static $primaryKey = 'id';
    private static $formName = 'form_KanbanEstagioForm';

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
        $this->form->setFormTitle("Cadastro de Estágio");


        $titulo = new TEntry('titulo');
        $projeto_id = new THidden('projeto_id');
        $id = new THidden('id');


        $titulo->setMaxLength(200);
        $id->setSize(200);
        $titulo->setSize('100%');
        $projeto_id->setSize(200);

        $row1 = $this->form->addFields([new TLabel("Título:", null, '14px', null, '100%'),$titulo,$projeto_id,$id]);
        $row1->layout = ['col-sm-6'];

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

            $object = new KanbanEstagio(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            /*if($param['projeto_id'])
            {
                $object->projeto_id = $param['projeto_id'];
            }*/

            if(!$data->id)
            {
                $estagio = KanbanEstagio::select('max(estagio_ordem) AS ordem')->where('projeto_id', '=', $object->projeto_id)->first();
                if($estagio)
                {
                    $object->estagio_ordem = $estagio->ordem + 1;
                }
            }

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

            TToast::show('success', "Estágio salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('KanbanView', 'onShow', $loadPageParam); 

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

                $object = new KanbanEstagio($key); // instantiates the Active Record 

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

        $object = new KanbanEstagio(); // create an empty object

        if (isset($param['projeto_id']))
        {
            $projeto_id = $param['projeto_id'];  // get the parameter $key
            $object->projeto_id = $projeto_id;
        }

        $this->form->setData($object); // fill the form
    } 

}

