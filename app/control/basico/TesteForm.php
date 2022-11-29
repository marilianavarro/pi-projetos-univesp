<?php

class TesteForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_TesteForm';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param = null)
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Testes");


        $button_testar_notificacao_do_telegram = new TButton('button_testar_notificacao_do_telegram');
        $button_testar_tarefa_agendada = new TButton('button_testar_tarefa_agendada');


        $button_testar_tarefa_agendada->setAction(new TAction([$this, 'onTestarCron']), "Testar Tarefa Agendada");
        $button_testar_notificacao_do_telegram->setAction(new TAction([$this, 'onTestarNotificacao']), "Testar Notificação do Telegram");

        $button_testar_tarefa_agendada->addStyleClass('btn-default');
        $button_testar_notificacao_do_telegram->addStyleClass('btn-default');

        $button_testar_tarefa_agendada->setImage('fas:tasks #000000');
        $button_testar_notificacao_do_telegram->setImage('fas:sms #000000');


        $row1 = $this->form->addFields([$button_testar_notificacao_do_telegram],[$button_testar_tarefa_agendada]);
        $row1->layout = [' col-sm-6',' col-sm-6'];

        // create the form actions

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Básico","Testes"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public  function onTestarNotificacao($param = null) 
    {
        try 
        {
            print "<pre>";
            NotificacaoService::notificar("Testando Notificação");
            print "</pre>";

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public  function onTestarCron($param = null) 
    {
        try 
        {
            //code here
            print "<pre>";
            CronService::notificarAtrasos();
            print "</pre>";

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onShow($param = null)
    {               

    } 

}

