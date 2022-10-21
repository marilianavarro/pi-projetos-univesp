<?php

class SystemPreference extends TRecord
{
    const TABLENAME  = 'system_preference';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'max'; // {max, serial}

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('preference');
    
    }

    /**
     * Retorna uma preferência
     * @param $id Id da preferência
     */
    public static function getPreference($id)
    {
        $preference = new SystemPreference($id);
        return $preference->preference;
    }

    /**
     * Altera uma preferência
     * @param $id  Id da preferência
     * @param $preference Valor da preferência
     */
    public static function setPreference($id, $value)
    {
        $preference = SystemPreference::find($id);
        if ($preference)
        {
            $preference->preference = $value;
            $preference->store();
        }
    }

    /**
     * Retorna um array com todas preferências
     */
    public static function getAllPreferences()
    {
        $rep = new TRepository('SystemPreference');
        $objects = $rep->load(new TCriteria);
        $dataset = array();
    
        if ($objects)
        {
            foreach ($objects as $object)
            {
                $property = $object->id;
                $preference = $object->preference;
                $dataset[$property] = $preference;
            }
        }
        return $dataset;
    }
    
}

