<?php
declare(strict_types=1);
namespace App\Controller;
use Cake\Core\Configure;
use Cake\Event\EventInterface;

class TelegramController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['webhook']);
    }

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Telegram');
        $this->loadModel('Users');
        $this->autoRender = false;
    }

    /**
     * Endpoint webhook Telegram
     */
    public function webhook()
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;
        $update = json_decode(file_get_contents('php://input'), true);
        if (empty($update['message'])) {
            echo "OK";
            return;
        }
        $message = $update['message'];
        $chatId  = $message['chat']['id'] ?? null;
        $text    = trim($message['text'] ?? '');
        // Hanya proses command /start
        if (strpos($text, '/start') !== 0) {
            echo "OK";
            return;
        }
        // Ambil user id dari "/start 2"
        $parts = explode(' ', $text);
        if (count($parts) < 2) {
            $this->Telegram->sendMessage($chatId, "❌ Link tidak valid. Silakan hubungkan akun dari Dashboard HRIS.");
            echo "OK";
            return;
        }
        $userId = (int)$parts[1];
        $user = $this->Users->find()
            ->where(['id' => $userId])
            ->first();
        if (!$user) {
            $this->Telegram->sendMessage($chatId, "❌ User HRIS tidak ditemukan.");
            echo "OK";
            return;
        }
        $user->telegram_chat_id = $chatId;
        if ($this->Users->save($user)) {
            $this->Telegram->sendMessage(
                $chatId,
                "✅ Akun Telegram berhasil dihubungkan dengan Website rssby.brgroup.id.\n\nMulai sekarang Anda akan menerima notifikasi approval melalui Telegram."
            );
        } else {
            $this->Telegram->sendMessage($chatId, "❌ Gagal menghubungkan akun.");
        }
        echo "OK";
    }
    /**
    //  * Kirim pesan Telegram
    //  */
    // private function sendMessage($chatId, $message)
    // {
    //     $token = Configure::read('Telegram.botToken');
    //     $url = "https://api.telegram.org/bot{$token}/sendMessage";
    //     $data = [
    //         'chat_id' => $chatId,
    //         'text' => $message
    //     ];
    //     $options = [
    //         'http' => [
    //             'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
    //             'method'  => 'POST',
    //             'content' => http_build_query($data),
    //         ]
    //     ];
    //     $context = stream_context_create($options);
    //     file_get_contents($url, false, $context);
    // }
}
