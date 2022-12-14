<?php

class Projeto extends TRecord
{
    const TABLENAME  = 'projeto';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}
    const CACHECONTROL  = 'TAPCache';

    const DELETEDAT  = 'datahora_excluido';
    const CREATEDAT  = 'datahora_criacao';
    const UPDATEDAT  = 'datahora_atualizacao';

    

    use SystemChangeLogTrait;
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('titulo');
        parent::addAttribute('datahora_criacao');
        parent::addAttribute('datahora_excluido');
        parent::addAttribute('datahora_atualizacao');
            
    }

    /**
     * Method getLogEventoss
     */
    public function getLogEventoss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('projeto_id', '=', $this->id));
        return LogEventos::getObjects( $criteria );
    }
    /**
     * Method getKanbanEstagios
     */
    public function getKanbanEstagios()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('projeto_id', '=', $this->id));
        return KanbanEstagio::getObjects( $criteria );
    }
    /**
     * Method getKanbanItems
     */
    public function getKanbanItems()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('projeto_id', '=', $this->id));
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
    
        $values = LogEventos::where('projeto_id', '=', $this->id)->getIndexedArray('estagio_id','{estagio->titulo}');
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
    
        $values = LogEventos::where('projeto_id', '=', $this->id)->getIndexedArray('projeto_id','{projeto->titulo}');
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
    
        $values = LogEventos::where('projeto_id', '=', $this->id)->getIndexedArray('usuario_id','{usuario->name}');
        return implode(', ', $values);
    }

    public function set_kanban_estagio_projeto_to_string($kanban_estagio_projeto_to_string)
    {
        if(is_array($kanban_estagio_projeto_to_string))
        {
            $values = Projeto::where('id', 'in', $kanban_estagio_projeto_to_string)->getIndexedArray('titulo', 'titulo');
            $this->kanban_estagio_projeto_to_string = implode(', ', $values);
        }
        else
        {
            $this->kanban_estagio_projeto_to_string = $kanban_estagio_projeto_to_string;
        }

        $this->vdata['kanban_estagio_projeto_to_string'] = $this->kanban_estagio_projeto_to_string;
    }

    public function get_kanban_estagio_projeto_to_string()
    {
        if(!empty($this->kanban_estagio_projeto_to_string))
        {
            return $this->kanban_estagio_projeto_to_string;
        }
    
        $values = KanbanEstagio::where('projeto_id', '=', $this->id)->getIndexedArray('projeto_id','{projeto->titulo}');
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
    
        $values = KanbanItem::where('projeto_id', '=', $this->id)->getIndexedArray('projeto_id','{projeto->titulo}');
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
    
        $values = KanbanItem::where('projeto_id', '=', $this->id)->getIndexedArray('estagio_id','{estagio->titulo}');
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
    
        $values = KanbanItem::where('projeto_id', '=', $this->id)->getIndexedArray('usuario_id','{usuario->name}');
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
    
        $values = KanbanItem::where('projeto_id', '=', $this->id)->getIndexedArray('status_id','{status->titulo}');
        return implode(', ', $values);
    }

    
}

