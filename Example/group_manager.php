<?php
// group_manager.php

require_once 'BaleBot.php';
require_once 'Models.php';

class GroupManagerBot {
    private $bot;
    private $adminIds = [1033494947]; // آیدی ادمین‌ها
    
    public function __construct($token) {
        $this->bot = new BaleBot($token);
    }
    
    public function handleUpdate($update) {
        if ($update->message) {
            $this->handleMessage($update->message);
        }
    }
    
    private function handleMessage(Message $message) {
        $chatId = $message->chat->id;
        $text = $message->text ?? '';
        $user = $message->from;
        $chatType = $message->chat->type;
        
        // فقط در گروه‌ها عمل کند
        if ($chatType !== 'group' && $chatType !== 'supergroup') {
            return;
        }
        
        // چک کردن دسترسی ادمین
        $isAdmin = in_array($user->id, $this->adminIds);
        
        if ($text === '/ban' && $isAdmin) {
            $this->banUser($message);
        }
        elseif ($text === '/mute' && $isAdmin) {
            $this->muteUser($message);
        }
        elseif ($text === '/warn' && $isAdmin) {
            $this->warnUser($message);
        }
        elseif ($text === '/info') {
            $this->sendGroupInfo($chatId);
        }
        elseif ($text === '/rules') {
            $this->sendRules($chatId);
        }
    }
    
    private function banUser(Message $message) {
        $chatId = $message->chat->id;
        $targetUserId = $this->getRepliedUserId($message);
        
        if ($targetUserId) {
            $this->bot->banChatMember($chatId, $targetUserId);
            $this->bot->sendMessage($chatId, "⛔ کاربر مسدود شد");
        }
    }
    
    private function muteUser(Message $message) {
        $chatId = $message->chat->id;
        $targetUserId = $this->getRepliedUserId($message);
        
        if ($targetUserId) {
            // محدود کردن کاربر (موت)
            $this->bot->restrictChatMember($chatId, $targetUserId, [
                'can_send_messages' => false,
                'can_send_media_messages' => false,
                'can_send_other_messages' => false
            ]);
            $this->bot->sendMessage($chatId, "🔇 کاربر موت شد");
        }
    }
    
    private function warnUser(Message $message) {
        $chatId = $message->chat->id;
        $targetUser = $this->getRepliedUser($message);
        
        if ($targetUser) {
            $warnText = "⚠️ اخطار به کاربر: " . $targetUser->first_name . "\n";
            $warnText .= "لطفاً قوانین گروه را رعایت کنید";
            
            $this->bot->sendMessage($chatId, $warnText);
        }
    }
    
    private function sendGroupInfo($chatId) {
        $info = $this->bot->getChat($chatId);
        $membersCount = $this->bot->getChatMembersCount($chatId);
        
        $text = "📊 اطلاعات گروه:\n\n";
        $text .= "🏷️ عنوان: " . ($info['title'] ?? 'بدون عنوان') . "\n";
        $text .= "👥 تعداد اعضا: " . $membersCount . "\n";
        $text .= "📝 توضیحات: " . ($info['description'] ?? 'ندارد') . "\n";
        
        $this->bot->sendMessage($chatId, $text);
    }
    
    private function sendRules($chatId) {
        $rules = "📜 قوانین گروه:\n\n";
        $rules .= "1️⃣ احترام متقابل را رعایت کنید\n";
        $rules .= "2️⃣ از ارسال محتوای نامناسب خودداری کنید\n";
        $rules .= "3️⃣ اسپم نکنید\n";
        $rules .= "4️⃣ از تبلیغات غیرمجاز خودداری کنید\n\n";
        $rules .= "⚠️ عدم رعایت قوانین منجر به اخطار یا حذف خواهد شد";
        
        $this->bot->sendMessage($chatId, $rules);
    }
    
    private function getRepliedUserId(Message $message) {
        if (isset($message->reply_to_message)) {
            return $message->reply_to_message->from->id;
        }
        return null;
    }
    
    private function getRepliedUser(Message $message) {
        if (isset($message->reply_to_message)) {
            return $message->reply_to_message->from;
        }
        return null;
    }
}

// استفاده
$token = 'YOUR_BOT_TOKEN';
$bot = new GroupManagerBot($token);

// برای وب‌هوک
$input = json_decode(file_get_contents('php://input'), true);
$update = new Update($input);
$bot->handleUpdate($update);

?>
