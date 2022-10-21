<?php

class NotificacaoService
{
    
    public static function notificar($message, $obj = null)
    {
        if(is_object($obj))
        {
            // Renderiza a mensagem conforme o banco de dados.
            $message = $obj->render($message);
        }
        
        // Captura o TOKEN do BOT no Application.ini
        $ini = parse_ini_file('app/config/application.ini');
        $token = $ini['token_telegram'];
    
        TTransaction::open('gestao');

        // Captura todas as notificações
        $objs = Notificacao::where('telegram_chatid',  '!=', '')->load();
        
        foreach($objs as $obj)
        {
            Funcao::telegram($message, $token, $obj->telegram_chatid);
        }
        
        TTransaction::close();
        
        //print $message;
    }
}
