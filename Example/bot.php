<?php
// bot.php - نسخه حرفه‌ای با کتابخانه

require_once 'BaleBot.php';
require_once 'Models.php';

define('BOT_TOKEN', '458334050:2p8SYgerTiaZBAPZ3ALfbIGephF5RscitI6jg13E');
define('ADMIN_ID', 1033494947);

class ProfessionalBaleBot {
    private $bot;
    
    public function __construct() {
        $this->bot = new BaleBot(BOT_TOKEN);
    }
    
    public function handleWebhook() {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input) {
                throw new Exception('Invalid JSON input');
            }
            
            $update = new Update($input);
            $this->processUpdate($update);
            
            http_response_code(200);
            echo 'OK';
            
        } catch (Exception $e) {
            http_response_code(500);
            error_log('Bot Error: ' . $e->getMessage());
            echo 'Error';
        }
    }
    
    private function processUpdate(Update $update) {
        if ($update->message) {
            $this->handleMessage($update->message);
        }
        
        if ($update->callback_query) {
            $this->handleCallbackQuery($update->callback_query);
        }
    }
    
    private function handleMessage(Message $message) {
        $chatId = $message->chat->id;
        $text = $message->text ?? '';
        $user = $message->from;
        
        // لاگ پیام
        $this->logMessage($user, $text);
        
        // پردازش دستورات
        switch (true) {
            case $text === '/start':
                $this->sendWelcomeMessage($chatId, $user);
                break;
                
            case $text === '/help':
                $this->sendHelpMessage($chatId);
                break;
                
            case $text === '/info':
                $this->sendUserInfo($chatId, $user);
                break;
                
            case $text === '/admin':
                $this->handleAdminCommand($chatId, $user);
                break;
                
            case strpos($text, '/') === 0:
                $this->sendUnknownCommand($chatId);
                break;
                
            default:
                $this->handleTextMessage($chatId, $text, $user);
        }
    }
    
    private function sendWelcomeMessage($chatId, User $user) {
        $text = "🌟 به ربات حرفه‌ای بله خوش آمدید!\n\n";
        $text .= "👋 سلام " . ($user->first_name ?? 'کاربر') . "!\n";
        $text .= "🤖 من با کتابخانه پیشرفته PHP ساخته شدم\n\n";
        $text .= "📋 دستورات موجود:\n";
        $text .= "/start - شروع کار\n";
        $text .= "/help - راهنمای کامل\n";
        $text .= "/info - اطلاعات کاربر\n";
        $text .= "/admin - اطلاعات ادمین";
        
        // ایجاد کیبورد شیک
        $keyboard = [
            'keyboard' => [
                ['📊 اطلاعات', '🆘 راهنما'],
                ['🌅 عکس نمونه', '🕒 زمان'],
                ['👨‍💻 توسعه دهنده']
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ];
        
        $this->bot->sendMessage($chatId, $text, null, json_encode($keyboard));
    }
    
    private function sendHelpMessage($chatId) {
        $text = "📖 راهنمای ربات حرفه‌ای\n\n";
        $text .= "✨ این ربات با ویژگی‌های زیر ساخته شده:\n\n";
        $text .= "✅ پردازش پیام‌های متنی\n";
        $text .= "✅ مدیریت کیبوردهای پیشرفته\n";
        $text .= "✅ سیستم لاگینگ حرفه‌ای\n";
        $text .= "✅ خطایابی پیشرفته\n";
        $text .= "✅ پشتیبانی از مدل‌های داده\n\n";
        $text .= "🛠️ توسعه داده شده با:\n";
        $text .= "• PHP 7.4+\n";
        $text .= "• Bale Bot API\n";
        $text .= "• کتابخانه اختصاصی";
        
        $this->bot->sendMessage($chatId, $text);
    }
    
    private function sendUserInfo($chatId, User $user) {
        $text = "👤 اطلاعات کاربری\n\n";
        $text .= "🆔 آیدی: `" . $user->id . "`\n";
        $text .= "👤 نام: " . ($user->first_name ?? '---') . "\n";
        $text .= "👥 نام خانوادگی: " . ($user->last_name ?? '---') . "\n";
        $text .= "📧 یوزرنیم: @" . ($user->username ?? 'ندارد') . "\n";
        $text .= "🤖 ربات: " . ($user->is_bot ? '✅' : '❌') . "\n";
        $text .= "🌐 زبان: " . ($user->language_code ?? '---') . "\n\n";
        $text .= "📊 این اطلاعات از طریق مدل User پردازش شده";
        
        $this->bot->sendMessage($chatId, $text);
    }
    
    private function handleAdminCommand($chatId, User $user) {
        if ($user->id == ADMIN_ID) {
            $text = "👨‍💻 پنل ادمین\n\n";
            $text .= "✅ شما دسترسی ادمین دارید\n";
            $text .= "🆔 آیدی شما: " . ADMIN_ID . "\n";
            $text .= "📊 تعداد کاربران: 1\n";
            $text .= "🟢 وضعیت: فعال";
        } else {
            $text = "⛔ دسترسی denied\n\n";
            $text .= "شما دسترسی ادمین ندارید!";
        }
        
        $this->bot->sendMessage($chatId, $text);
    }
    
    private function handleTextMessage($chatId, $text, User $user) {
        $responses = [
            'سلام' => "سلام " . ($user->first_name ?? 'کاربر') . "! 👋\nچطور میتونم کمک کنم؟",
            'خداحافظ' => "خدانگهدار! 🙋‍♂️\nامیدوارم بازم ببینمت",
            'چطوری' => "من یک ربات هستم، همیشه خوبم! 😊\nشما چطورید؟",
            'ممنون' => "خواهش می‌کنم! 🤗\nهمیشه در خدمت شما هستم",
            'زمان' => "🕒 زمان فعلی: " . date('Y-m-d H:i:s'),
            'عکس' => $this->sendSamplePhoto($chatId),
            'توسعه دهنده' => "👨‍💻 توسعه دهنده: @Daniyel\n📧 برای همکاری: daniyel@email.com"
        ];
        
        if (isset($responses[$text])) {
            $this->bot->sendMessage($chatId, $responses[$text]);
        } else {
            $this->bot->sendMessage($chatId, 
                "🤔 پیام شما: \"{$text}\"\n\n" .
                "💡 از /help برای دیدن دستورات استفاده کنید"
            );
        }
    }
    
    private function sendSamplePhoto($chatId) {
        $photoUrl = 'https://picsum.photos/400/300';
        $caption = '🌄 عکس نمونه ارسال شده توسط ربات حرفه‌ای';
        
        $this->bot->sendPhoto($chatId, $photoUrl, $caption);
        return 'عکس ارسال شد! ✅';
    }
    
    private function sendUnknownCommand($chatId) {
        $text = "❌ دستور ناشناخته\n\n";
        $text .= "این دستور وجود ندارد!\n";
        $text .= "برای دیدن دستورات موجود از /help استفاده کنید";
        
        $this->bot->sendMessage($chatId, $text);
    }
    
    private function handleCallbackQuery(CallbackQuery $callbackQuery) {
        $this->bot->answerCallbackQuery($callbackQuery->id, 
            "✅ عملیات انجام شد", 
            false
        );
    }
    
    private function logMessage(User $user, $text) {
        $log = sprintf(
            "[%s] User: %s (%d) @%s - Message: %s\n",
            date('Y-m-d H:i:s'),
            $user->first_name ?? 'Unknown',
            $user->id,
            $user->username ?? 'no_username',
            $text
        );
        
        file_put_contents('bot.log', $log, FILE_APPEND);
    }
}

// اجرای ربات
$bot = new ProfessionalBaleBot();
$bot->handleWebhook();

?>
