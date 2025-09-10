# Bale Bot PHP SDK

یک کتابخانه حرفه‌ای و کامل PHP برای توسعه ربات‌های پیام‌رسان بله (Bale.ir)

![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)
![API Coverage](https://img.shields.io/badge/API%20Coverage-100%25-brightgreen.svg)

## 📦 ویژگی‌ها

- ✅ پشتیبانی از تمام متدهای API بله (60+ متد)
- ✅ طراحی شی‌گرا و مدرن
- ✅ مدیریت خطاهای پیشرفته
- ✅ پشتیبانی از وب‌هوک و long polling
- ✅ مدل‌های داده type-safe
- ✅ مستندات کامل
- ✅ تست‌های یکپارچه

## 🚀 نصب و راه‌اندازی

### نصب via Composer

```bash
composer require yourname/bale-bot-sdk
```
نصب دستی
```
php
require_once 'BaleBot.php';
require_once 'Models.php';
📋 نیازمندی‌ها
PHP 7.4 یا بالاتر

extension curl

extension json
```
🔧 استفاده سریع
راه‌اندازی ربات
```php
<?php
require_once 'BaleBot.php';

$token = 'YOUR_BOT_TOKEN';
$bot = new BaleBot($token);

// تست اتصال
$botInfo = $bot->getMe();
echo "ربات: " . $botInfo['first_name'] . " (@".$botInfo['username'].")";
?>
```
ارسال پیام
```php
// ارسال پیام متنی
$bot->sendMessage('CHAT_ID', 'سلام دنیا! 👋');

// ارسال عکس
$bot->sendPhoto('CHAT_ID', 'https://example.com/photo.jpg', 'توضیح عکس');

// ارسال موقعیت
$bot->sendLocation('CHAT_ID', 35.6892, 51.3890);
```
مدیریت گروه
```php
// مسدود کردن کاربر
$bot->banChatMember('GROUP_ID', 'USER_ID');

// تغییر عنوان گروه
$bot->setChatTitle('GROUP_ID', 'عنوان جدید گروه');

// دریافت اطلاعات گروه
$groupInfo = $bot->getChat('GROUP_ID');
```
📖 مستندات متدها
متدهای اصلی
متد	توضیح	پارامترها
```php
getMe()	اطلاعات ربات	-
sendMessage()	ارسال پیام	chat_id, text, reply_markup
sendPhoto()	ارسال عکس	chat_id, photo, caption
sendDocument()	ارسال فایل	chat_id, document, caption
مدیریت گروه
متد	توضیح
banChatMember()	مسدود کردن کاربر
promoteChatMember()	ارتقاء به ادمین
setChatTitle()	تغییر عنوان گروه
getChatMembersCount()	تعداد اعضای گروه
مدیریت پیام‌ها
متد	توضیح
editMessageText()	ویرایش پیام
deleteMessage()	حذف پیام
pinChatMessage()	سنجاق کردن پیام
```
🎯 مثال‌های پیشرفته
ربات وب‌هوک
```php
<?php
require_once 'BaleBot.php';
require_once 'Models.php';

$bot = new BaleBot('YOUR_TOKEN');
$input = json_decode(file_get_contents('php://input'), true);
$update = new Update($input);

if ($update->message) {
    $chatId = $update->message->chat->id;
    $text = $update->message->text;
    
    if ($text === '/start') {
        $bot->sendMessage($chatId, 'خوش آمدید! 🤖');
    }
}

http_response_code(200);
?>
```
ربات Long Polling
```php
<?php
$bot = new BaleBot('YOUR_TOKEN');
$offset = 0;

while (true) {
    $updates = $bot->getUpdates($offset);
    
    foreach ($updates as $update) {
        $offset = $update['update_id'] + 1;
        // پردازش آپدیت‌ها
    }
    
    sleep(1);
}
?>
```
🔄 مدل‌های داده
کلاس User
```php
$user = new User([
    'id' => 123456789,
    'first_name' => 'John',
    'username' => 'johndoe'
]);
کلاس Message
php
$message = new Message($update['message']);
echo $message->text;
echo $message->from->first_name;
```
🛠️ توسعه و مشارکت
ساختار پروژه
```text
src/
├── BaleBot.php      # کلاس اصلی
├── Models.php       # مدل‌های داده
├── Examples/        # مثال‌های کاربردی
└── Tests/           # تست‌های واحد
```
اجرای تست‌ها
```bash
php tests/BasicTest.php
```
راهنمای مشارکت
Fork پروژه

ایجاد branch جدید

commit تغییرات

push به branch

ایجاد Pull Request

📊 وضعیت متدها
دسته	تعداد	وضعیت
پیام‌ها	15	✅ کامل
گروه‌ها	12	✅ کامل
مدیا	8	✅ کامل
پرداخت	5	✅ کامل
استیکر	4	✅ کامل
وب‌هوک	3	✅ کامل
🚀 استقرار
روی هاست اشتراکی
```bash
# آپلود فایل‌ها
scp -r src/* user@server:/path/to/bot/
```
# تنظیم وب‌هوک
```php set_webhook.php
با Docker
dockerfile
FROM php:7.4-cli
COPY src/ /app/
WORKDIR /app
CMD ["php", "bot.php"]
```
📝 لایسنس
این پروژه تحت لایسنس MIT منتشر شده است.

text
MIT License
Copyright (c) 2025 Your Name

اجازه استفاده، کپی، تغییر، ادغام، انتشار، توزیع،
فروش و فروش مجدد نرم‌افزار را به هر شخصی می‌دهد.
🤝 پشتیبانی
📧 Email: your.email@example.com

💬 Telegram: @yourusername

🐛 Issues: GitHub Issues

📜 تاریخچه نسخه‌ها
v1.0.0 (2025-09-10)
اولین نسخه پایدار

پشتیبانی از تمام متدهای API

مستندات کامل

مثال‌های کاربردی

توسعه داده شده با ❤️ برای جامعه فارسی‌زبان

![Powered%20by
Po](https://img.shields.io/badge/Powered%2520by-Bale.ir-blue.svg)
