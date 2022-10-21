<?php

class SystemUserProgram extends TRecord
{
    const TABLENAME  = 'system_user_program';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'max'; // {max, serial}

    private $system_program;
    private $system_user;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('system_user_id');
        parent::addAttribute('system_program_id');
            
    }

    /**
     * Method set_system_program
     * Sample of usage: $var->system_program = $object;
     * @param $object Instance of SystemProgram
     */
    public function set_system_program(SystemProgram $object)
    {
        $this->system_program = $object;
        $this->system_program_id = $object->id;
    }

    /**
     * Method get_system_program
     * Sample of usage: $var->system_program->attribute;
     * @returns SystemProgram instance
     */
    public function get_system_program()
    {
    
        // loads the associated object
        if (empty($this->system_program))
            $this->system_program = new SystemProgram($this->system_program_id);
    
        // returns the associated object
        return $this->system_program;
    }
    /**
     * Method set_system_users
     * Sample of usage: $var->system_users = $object;
     * @param $object Instance of SystemUsers
     */
    public function set_system_user(SystemUsers $object)
    {
        $this->system_user = $object;
        $this->system_user_id = $object->id;
    }

    /**
     * Method get_system_user
     * Sample of usage: $var->system_user->attribute;
     * @returns SystemUsers instance
     */
    public function get_system_user()
    {
    
        // loads the associated object
        if (empty($this->system_user))
            $this->system_user = new SystemUsers($this->system_user_id);
    
        // returns the associated object
        return $this->system_user;
    }

    
}

