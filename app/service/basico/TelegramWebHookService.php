<?php

class TelegramWebHookService
{
    public function show($param)
    {
        $content = file_get_contents("php://input");
        $update = json_decode($content, true);
        $chat_id = $update["message"]["chat"]["id"] ?? null;
        $chat_username = $update["message"]["chat"]["username"] ?? null;
        $message = $update["message"]["text"] ?? null;

        if(!$chat_id)
        {
            print "Erro.";
            exit;
        }
        
        $args = explode(' ', trim($message));
        $command = ltrim(array_shift($args), '/');

        // Captura o TOKEN do BOT no Application.ini
        $ini = parse_ini_file('app/config/application.ini');
        $token = $ini['token_telegram'];

        if($command == "start")
        {
            $notificacao_id = $args[1] ?? null;
            if($notificacao_id)
            {
                // Se o comando for /start e tiver o ID da Notificação, cadastra ele.
                TTransaction::open('gestao');
        
                $objeto = Notificacao::find( $notificacao_id );
                if($objeto)
                {
                    $objeto->telegram_chatid = $chat_id;
                    $objeto->telegram_usuario = $chat_username;
                    $objeto->store();    
                }
        
                TTransaction::close();
                
                $message = "✅Olá {$chat_username}, apartir de agora você irá receber as notificações por aqui :)";
                
                Funcao::telegram($message, $token, $chat_id);
            }
            else
            {
                $message = "⚠️ Ops! Só é permitido cadastro em nosso BOT através de nosso sistema de Gestão de Projetos.";
                    
                Funcao::telegram($message, $token, $chat_id);
            }
        }
        else
        {
            $message = "⚠️ Ops! Você digitou algum comando inválido.";
                
            Funcao::telegram($message, $token, $chat_id);
        }
        

    }
}
