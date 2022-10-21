<?php

class KanbanEstagio extends TRecord
{
    const TABLENAME  = 'kanban_estagio';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const DELETEDAT  = 'datahora_excluido';
    const CREATEDAT  = 'datahora_criacao';
    const UPDATEDAT  = 'datahora_atualizacao';

    private $projeto;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('projeto_id');
        parent::addAttribute('titulo');
        parent::addAttribute('estagio_ordem');
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
     * Method getLogEventoss
     */
    public function getLogEventoss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('estagio_id', '=', $this->id));
        return LogEventos::getObjects( $criteria );
    }
    /**
     * Method getKanbanItems
     */
    public function getKanbanItems()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('estagio_id', '=', $this->id));
        return KanbanItem::getObjects( $criteria );
    }

    public function set_log_eventos_estagio_to_string($log_eventos_estagio_to_string)
    {
        if(is_array($log_eventos_estagio_to_string))
        {
            $values = KanbanEstagio::where('id', 'in', $log_eventos_estagio_to_string)->getIndexedArray('titulo', 'titulo');
            $this->log_eventos_estagio_to_string = implode(', ', $values);
        }
        else
        {
            $this->log_eventos_estagio_to_string = $log_eventos_estagio_to_string;
        }

        $this->vdata['log_eventos_estagio_to_string'] = $this->log_eventos_estagio_to_string;
    }

    public function get_log_eventos_estagio_to_string()
    {
        if(!empty($this->log_eventos_estagio_to_string))
        {
            return $this->log_eventos_estagio_to_string;
        }
    
        $values = LogEventos::where('estagio_id', '=', $this->id)->getIndexedArray('estagio_id','{estagio->titulo}');
        return implode(', ', $values);
    }

    public function set_log_eventos_projeto_to_string($log_eventos_projeto_to_string)
    {
        if(is_array($log_eventos_projeto_to_string))
        {
            $values = Projeto::where('id', 'in', $log_eventos_projeto_to_string)->getIndexedArray('titulo', 'titulo');
            $this->log_eventos_projeto_to_string = implode(', ', $values);
        }
        else
        {
            $this->log_eventos_projeto_to_string = $log_eventos_projeto_to_string;
        }

        $this->vdata['log_eventos_projeto_to_string'] = $this->log_eventos_projeto_to_string;
    }

    public function get_log_eventos_projeto_to_string()
    {
        if(!empty($this->log_eventos_projeto_to_string))
        {
            return $this->log_eventos_projeto_to_string;
        }
    
        $values = LogEventos::where('estagio_id', '=', $this->id)->getIndexedArray('projeto_id','{projeto->titulo}');
        return implode(', ', $values);
    }

    public function set_log_eventos_usuario_to_string($log_eventos_usuario_to_string)
    {
        if(is_array($log_eventos_usuario_to_string))
        {
            $values = SystemUsers::where('id', 'in', $log_eventos_usuario_to_string)->getIndexedArray('name', 'name');
            $this->log_eventos_usuario_to_string = implode(', ', $values);
        }
        else
        {
            $this->log_eventos_usuario_to_string = $log_eventos_usuario_to_string;
        }

        $this->vdata['log_eventos_usuario_to_string'] = $this->log_eventos_usuario_to_string;
    }

    public function get_log_eventos_usuario_to_string()
    {
        if(!empty($this->log_eventos_usuario_to_string))
        {
            return $this->log_eventos_usuario_to_string;
        }
    
        $values = LogEventos::where('estagio_id', '=', $this->id)->getIndexedArray('usuario_id','{usuario->name}');
        return implode(', ', $values);
    }

    public function set_kanban_item_projeto_to_string($kanban_item_projeto_to_string)
    {
        if(is_array($kanban_item_projeto_to_string))
        {
            $values = Projeto::where('id', 'in', $kanban_item_projeto_to_string)->getIndexedArray('titulo', 'titulo');
            $this->kanban_item_projeto_to_string = implode(', ', $values);
        }
        else
        {
            $this->kanban_item_projeto_to_string = $kanban_item_projeto_to_string;
        }

        $this->vdata['kanban_item_projeto_to_string'] = $this->kanban_item_projeto_to_string;
    }

    public function get_kanban_item_projeto_to_string()
    {
        if(!empty($this->kanban_item_projeto_to_string))
        {
            return $this->kanban_item_projeto_to_string;
        }
    
        $values = KanbanItem::where('estagio_id', '=', $this->id)->getIndexedArray('projeto_id','{projeto->titulo}');
        return implode(', ', $values);
    }

    public function set_kanban_item_estagio_to_string($kanban_item_estagio_to_string)
    {
        if(is_array($kanban_item_estagio_to_string))
        {
            $values = KanbanEstagio::where('id', 'in', $kanban_item_estagio_to_string)->getIndexedArray('titulo', 'titulo');
            $this->kanban_item_estagio_to_string = implode(', ', $values);
        }
        else
        {
            $this->kanban_item_estagio_to_string = $kanban_item_estagio_to_string;
        }

        $this->vdata['kanban_item_estagio_to_string'] = $this->kanban_item_estagio_to_string;
    }

    public function get_kanban_item_estagio_to_string()
    {
        if(!empty($this->kanban_item_estagio_to_string))
        {
            return $this->kanban_item_estagio_to_string;
        }
    
        $values = KanbanItem::where('estagio_id', '=', $this->id)->getIndexedArray('estagio_id','{estagio->titulo}');
        return implode(', ', $values);
    }

    public function set_kanban_item_usuario_to_string($kanban_item_usuario_to_string)
    {
        if(is_array($kanban_item_usuario_to_string))
        {
            $values = SystemUsers::where('id', 'in', $kanban_item_usuario_to_string)->getIndexedArray('name', 'name');
            $this->kanban_item_usuario_to_string = implode(', ', $values);
        }
        else
        {
            $this->kanban_item_usuario_to_string = $kanban_item_usuario_to_string;
        }

        $this->vdata['kanban_item_usuario_to_string'] = $this->kanban_item_usuario_to_string;
    }

    public function get_kanban_item_usuario_to_string()
    {
        if(!empty($this->kanban_item_usuario_to_string))
        {
            return $this->kanban_item_usuario_to_string;
        }
    
        $values = KanbanItem::where('estagio_id', '=', $this->id)->getIndexedArray('usuario_id','{usuario->name}');
        return implode(', ', $values);
    }

    public function set_kanban_item_status_to_string($kanban_item_status_to_string)
    {
        if(is_array($kanban_item_status_to_string))
        {
            $values = Status::where('id', 'in', $kanban_item_status_to_string)->getIndexedArray('titulo', 'titulo');
            $this->kanban_item_status_to_string = implode(', ', $values);
        }
        else
        {
            $this->kanban_item_status_to_string = $kanban_item_status_to_string;
        }

        $this->vdata['kanban_item_status_to_string'] = $this->kanban_item_status_to_string;
    }

    public function get_kanban_item_status_to_string()
    {
        if(!empty($this->kanban_item_status_to_string))
        {
            return $this->kanban_item_status_to_string;
        }
    
        $values = KanbanItem::where('estagio_id', '=', $this->id)->getIndexedArray('status_id','{status->titulo}');
        return implode(', ', $values);
    }

    
}

