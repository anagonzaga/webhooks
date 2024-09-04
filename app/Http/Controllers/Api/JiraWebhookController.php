<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class JiraWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Processa os dados recebidos do Jira
        $data = $request->all();

        // Formata a mensagem para enviar ao Telegram
        $message = "Novo evento do Jira:\n";
        $message .= "Issue: " . $data['issue']['key'] . "\n";
        $message .= "Resumo: " . $data['issue']['fields']['summary'] . "\n";
        $message .= "Usuário: " . $data['user']['displayName'] . "\n";

        // Envia a mensagem ao Telegram
        $this->sendMessageToTelegram($message);

        return response()->json(['status' => 'success']);
    }

    protected function sendMessageToTelegram($message)
    {
         Telegram::sendMessage([
            'chat_id' => '-4247010997',
            'text' => $message,
            'parse_mode' => 'Markdown' // Use 'Markdown' para formatação, 'HTML' se preferir HTML
        ]);
    }
}
