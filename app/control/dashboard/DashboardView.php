<?php

class DashboardView extends TPage
{
    public function __construct($param)
    {
        parent::__construct();
        
        $title = "Dashboard - Gestão de Projetos";
        $link = "https://app.powerbi.com/view?r=eyJrIjoiZjc5Yjk3OWItYmVhYi00NGJiLWI5M2EtMGEzZTdmNWRlOTRjIiwidCI6ImNlOTIxMjI5LTJhYmEtNDQ4Zi05NWI2LTE5MGUwZjdlY2YxNCJ9";
        
        $html = '<iframe title="' . $title. '" width="100%" height="1000" src="' . $link. '" frameborder="0" allowFullScreen="true"></iframe>';
        
        parent::add($html);
    }
    
    // função executa ao clicar no item de menu
    public function onShow($param = null)
    {
        
    }
}
