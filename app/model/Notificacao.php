<?php

class Notificacao extends TRecord
{
    const TABLENAME  = 'notificacao';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const DELETEDAT  = 'datahora_excluido';
    const CREATEDAT  = 'datahora_criacao';
    const UPDATEDAT  = 'datahora_atualizacao';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('telegram_chatid');
        parent::addAttribute('telegram_usuario');
        parent::addAttribute('datahora_criacao');
        parent::addAttribute('datahora_excluido');
        parent::addAttribute('datahora_atualizacao');
            
    }

    
}

