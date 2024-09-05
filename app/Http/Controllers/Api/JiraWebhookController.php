<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class JiraWebhookController extends Controller
{
    public function index(Request $request)
    {
        // Processa os dados recebidos do Jira
        $data = $request->all();

        $message = "### Novo evento do Jira:\n\n";
        $message .= "**Data e Hora:** " . date('d/m/Y H:i:s') . "\n" .  "\n";
        $message .= "**Issue:** " . $data['issue']['key']  . "\n";
        $message .= "**Versão:** " . $data['issue']['fields']['version']  . "\n";
        $message .= "**Resumo:** " . $data['issue']['fields']['summary']  . "\n";
        $message .= "**Usuário:** " . $data['user']['displayName']  . "\n";
        $message .= "**Sistema/Aplicativo:** " . $data['issue']['fields']['project']  . "\n";

        // Envia a mensagem ao Telegram
        $this->sendMessageToTelegram($message);

        return response()->json(['status' => 'success']);
    }

    protected function sendMessageToTelegram($message)
    {
         Telegram::sendMessage([
            'chat_id' => '-4578547716',
            'text' => $message,
            'parse_mode' => 'Markdown'
        ]);
    }
}
