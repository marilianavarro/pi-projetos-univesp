<?php

class KanbanItem extends TRecord
{
    const TABLENAME  = 'kanban_item';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const DELETEDAT  = 'datahora_excluido';
    const CREATEDAT  = 'datahora_criacao';
    const UPDATEDAT  = 'datahora_atualizacao';

    private $projeto;
    private $usuario;
    private $status;
    private $estagio;

    use SystemChangeLogTrait;
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('projeto_id');
        parent::addAttribute('estagio_id');
        parent::addAttribute('usuario_id');
        parent::addAttribute('status_id');
        parent::addAttribute('titulo');
        parent::addAttribute('descricao');
        parent::addAttribute('item_ordem');
        parent::addAttribute('datahora_inicio');
        parent::addAttribute('datahora_fim');
        parent::addAttribute('datahora_criacao');
        parent::addAttribute('datahora_excluido');
        parent::addAttribute('datahora_atualizacao');
    
    }

    /**
     * Method set_projeto
     * Sample of usage: $var->projeto = $object;
     * @param $object Instance of Projeto
     */
    public function set_projeto(Projeto $object)
    {
        $this->projeto = $object;
        $this->projeto_id = $object->id;
    }

    /**
     * Method get_projeto
     * Sample of usage: $var->projeto->attribute;
     * @returns Projeto instance
     */
    public function get_projeto()
    {
    
        // loads the associated object
        if (empty($this->projeto))
            $this->projeto = new Projeto($this->projeto_id);
    
        // returns the associated object
        return $this->projeto;
    }
    /**
     * Method set_system_users
     * Sample of usage: $var->system_users = $object;
     * @param $object Instance of SystemUsers
     */
    public function set_usuario(SystemUsers $object)
    {
        $this->usuario = $object;
        $this->usuario_id = $object->id;
    }

    /**
     * Method get_usuario
     * Sample of usage: $var->usuario->attribute;
     * @returns SystemUsers instance
     */
    public function get_usuario()
    {
    
        // loads the associated object
        if (empty($this->usuario))
            $this->usuario = new SystemUsers($this->usuario_id);
    
        // returns the associated object
        return $this->usuario;
    }
    /**
     * Method set_status
     * Sample of usage: $var->status = $object;
     * @param $object Instance of Status
     */
    public function set_status(Status $object)
    {
        $this->status = $object;
        $this->status_id = $object->id;
    }

    /**
     * Method get_status
     * Sample of usage: $var->status->attribute;
     * @returns Status instance
     */
    public function get_status()
    {
    
        // loads the associated object
        if (empty($this->status))
            $this->status = new Status($this->status_id);
    
        // returns the associated object
        return $this->status;
    }
    /**
     * Method set_kanban_estagio
     * Sample of usage: $var->kanban_estagio = $object;
     * @param $object Instance of KanbanEstagio
     */
    public function set_estagio(KanbanEstagio $object)
    {
        $this->estagio = $object;
        $this->estagio_id = $object->id;
    }

    /**
     * Method get_estagio
     * Sample of usage: $var->estagio->attribute;
     * @returns KanbanEstagio instance
     */
    public function get_estagio()
    {
    
        // loads the associated object
        if (empty($this->estagio))
            $this->estagio = new KanbanEstagio($this->estagio_id);
    
        // returns the associated object
        return $this->estagio;
    }

    public function get_datahora_inicio_br()
    {
        return date("d/m/Y H:i:s", strtotime($this->datahora_fim));
    }

    public function get_datahora_fim_br()
    {
        return date("d/m/Y H:i:s", strtotime($this->datahora_fim));
    }

    public function get_tempo_percorrido()
    {
        return Funcao::get_date_diff($this->datahora_fim, strtotime('now'));
    }
    
}

