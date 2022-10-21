<?php

class SystemGroupProgram extends TRecord
{
    const TABLENAME  = 'system_group_program';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'max'; // {max, serial}

    private $system_program;
    private $system_group;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('system_group_id');
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
     * Method set_system_group
     * Sample of usage: $var->system_group = $object;
     * @param $object Instance of SystemGroup
     */
    public function set_system_group(SystemGroup $object)
    {
        $this->system_group = $object;
        $this->system_group_id = $object->id;
    }

    /**
     * Method get_system_group
     * Sample of usage: $var->system_group->attribute;
     * @returns SystemGroup instance
     */
    public function get_system_group()
    {
    
        // loads the associated object
        if (empty($this->system_group))
            $this->system_group = new SystemGroup($this->system_group_id);
    
        // returns the associated object
        return $this->system_group;
    }

    
}

