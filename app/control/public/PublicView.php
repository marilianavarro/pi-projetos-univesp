<?php

class PublicView extends TPage
{
    public function __construct()
    {
        parent::__construct();
        
        //TApplication::loadPage('LoginForm');
        
        
        $html = new THtmlRenderer('app/resources/public.html');

        // replace the main section variables
        $html->enableSection('main', array());
        
        // $panel = new TPanelGroup('Public!');
        // $panel->add($html);
        // $panel->style = 'margin: 100px';
        
        // add the template to the page
        parent::add( $html );
        
    }
    
    /*function teste2()
    {
        parent::__construct();
        
        $html1 = new THtmlRenderer('app/resources/system_welcome_en.html');
        $html2 = new THtmlRenderer('app/resources/system_welcome_pt.html');
        $html3 = new THtmlRenderer('app/resources/system_welcome_es.html');

        // replace the main section variables
        $html1->enableSection('main', array());
        $html2->enableSection('main', array());
        $html3->enableSection('main', array());
        
        $panel1 = new TPanelGroup('Welcome!');
        $panel1->add($html1);
        
        $panel2 = new TPanelGroup('Bem-vindo!');
        $panel2->add($html2);
		
        $panel3 = new TPanelGroup('Bienvenido!');
        $panel3->add($html3);
        
        $vbox = TVBox::pack($panel1, $panel2, $panel3);
        $vbox->style = 'display:block; width: 100%';
        
        // add the template to the page
        parent::add( $vbox );
    }*/
}
