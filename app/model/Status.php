<?php

class Status extends TRecord
{
    const TABLENAME  = 'status';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const DELETEDAT  = 'datahora_excluido';
    const CREATEDAT  = 'datahora_criacao';
    const UPDATEDAT  = 'datahora_atualizacao';

    const NaoIniciado = '1';
    const EmAndamento = '2';
    const Finalizado = '3';
    const Cancelado = '4';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('titulo');
        parent::addAttribute('cor');
        parent::addAttribute('datahora_criacao');
        parent::addAttribute('datahora_excluido');
        parent::addAttribute('datahora_atualizacao');
            
    }

    /**
     * Method getKanbanItems
     */
    public function getKanbanItems()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('status_id', '=', $this->id));
        return KanbanItem::getObjects( $criteria );
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
    
        $values = KanbanItem::where('status_id', '=', $this->id)->getIndexedArray('projeto_id','{projeto->titulo}');
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
    
        $values = KanbanItem::where('status_id', '=', $this->id)->getIndexedArray('estagio_id','{estagio->titulo}');
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
    
        $values = KanbanItem::where('status_id', '=', $this->id)->getIndexedArray('usuario_id','{usuario->name}');
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
    
        $values = KanbanItem::where('status_id', '=', $this->id)->getIndexedArray('status_id','{status->titulo}');
        return implode(', ', $values);
    }

    
}

