<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class TelegramComponent extends Component
{
    public function sendMessage($chatId, $message)
    {
        if (empty($chatId)) {
            return false;
        }
        $token = Configure::read('Telegram.botToken');
        $url = "https://api.telegram.org/bot{$token}/sendMessage";
        $data = [
            'chat_id' => $chatId,
            'text' => $message
        ];
        $options = [
            'http' => [
                'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ]
        ];
        $context = stream_context_create($options);
        return file_get_contents($url, false, $context);
    }

    public function notifyKnowing($module, $message, array $excludedChatIds = [])
    {
        $Users = TableRegistry::getTableLocator()->get('Users');
        $users = $Users->find()->all();
        $excludedChatIds = array_map('strval', $excludedChatIds);
        $sentChatIds = [];
        foreach ($users as $user) {
            if (empty($user->telegram_chat_id)) {
                continue;
            }
            $chatId = (string)$user->telegram_chat_id;
            if (in_array($chatId, $excludedChatIds, true) || isset($sentChatIds[$chatId])) {
                continue;
            }
            $rules = $this->_rule($user->rules);
            if (
                isset($rules[$module]['knowing']) &&
                $rules[$module]['knowing'] == 1
            ) {
                $this->sendMessage(
                    $user->telegram_chat_id,
                    $message
                );
                $sentChatIds[$chatId] = true;
            }
        }
    }
    public function notifyApprove($module, $message)
    {
        $Users = TableRegistry::getTableLocator()->get('Users');
        $users = $Users->find()->all();
        foreach ($users as $user) {
            if (empty($user->telegram_chat_id)) {
                continue;
            }
            $rules = $this->_rule($user->rules);
            if (
                isset($rules[$module]['approve']) &&
                $rules[$module]['approve'] == 1
            ) {
                $this->sendMessage(
                    $user->telegram_chat_id,
                    $message
                );
            }
        }
    }
    public function notifyApproveAcc($module, $message)
    {
        $Users = TableRegistry::getTableLocator()->get('Users');
        $users = $Users->find()->all();
        foreach ($users as $user) {
            if (empty($user->telegram_chat_id)) {
                continue;
            }
            $rules = $this->_rule($user->rules);
            if (
                isset($rules[$module]['approveAcc']) &&
                $rules[$module]['approveAcc'] == 1
            ) {
                $this->sendMessage(
                    $user->telegram_chat_id,
                    $message
                );
            }
        }
    }
    public function notifyUser($userId, $message)
    {
        $Users = TableRegistry::getTableLocator()->get('Users');
        $user = $Users->find()
            ->where(['Users.id' => $userId])
            ->first();
        if (empty($user) || empty($user->telegram_chat_id)) {
            return false;
        }
        return $this->sendMessage($user->telegram_chat_id, $message);
    }
    private function _rule($data = null)
    {
        $result = [];
        if (empty($data)) {
            return $result;
        }
        $dataRule = explode(';', $data);
        foreach ($dataRule as $valRule) {
            $dataAction = explode('=', $valRule);
            if (count($dataAction) != 2) {
                continue;
            }
            $_act = [];
            foreach (explode(',', $dataAction[1]) as $act) {
                $splitAct = explode(':', $act);
                if (count($splitAct) == 2) {
                    $_act[$splitAct[0]] = $splitAct[1];
                }
            }
            $result[$dataAction[0]] = $_act;
        }
        return $result;
    }
}
