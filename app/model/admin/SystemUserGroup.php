<?php

class SystemUserGroup extends TRecord
{
    const TABLENAME  = 'system_user_group';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'max'; // {max, serial}

    private $system_group;
    private $system_user;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('system_user_id');
        parent::addAttribute('system_group_id');
            
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

