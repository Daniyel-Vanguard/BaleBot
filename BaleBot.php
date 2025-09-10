<?php
// BaleBot.php - کتابخانه کامل API بله

class BaleBot {
    private $token;
    private $apiUrl = 'https://tapi.bale.ai';
    
    public function __construct($token) {
        $this->token = $token;
    }
    
    private function callApi($method, $data = []) {
        $url = $this->apiUrl . '/bot' . $this->token . '/' . $method;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, true);
            
            $isMultipart = false;
            foreach ($data as $value) {
                if (is_string($value) && substr($value, 0, 1) === '@') {
                    $isMultipart = true;
                    break;
                }
            }
            
            if ($isMultipart) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            }
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            throw new Exception("API request failed with HTTP code: {$httpCode} - {$error}");
        }
        
        $result = json_decode($response, true);
        
        if (!$result['ok']) {
            throw new Exception("API error: " . ($result['description'] ?? 'Unknown error'));
        }
        
        return $result['result'];
    }

    // Basic Methods
    public function getMe() {
        return $this->callApi('getMe');
    }
    
    public function sendMessage($chatId, $text, $replyToMessageId = null, $replyMarkup = null) {
        $data = [
            'chat_id' => $chatId,
            'text' => $text
        ];
        
        if ($replyToMessageId !== null) {
            $data['reply_to_message_id'] = $replyToMessageId;
        }
        
        if ($replyMarkup !== null) {
            $data['reply_markup'] = $replyMarkup;
        }
        
        return $this->callApi('sendMessage', $data);
    }
    
    public function forwardMessage($chatId, $fromChatId, $messageId) {
        return $this->callApi('forwardMessage', [
            'chat_id' => $chatId,
            'from_chat_id' => $fromChatId,
            'message_id' => $messageId
        ]);
    }
    
    public function copyMessage($chatId, $fromChatId, $messageId) {
        return $this->callApi('copyMessage', [
            'chat_id' => $chatId,
            'from_chat_id' => $fromChatId,
            'message_id' => $messageId
        ]);
    }
    
    // Media Methods
    public function sendPhoto($chatId, $photo, $caption = null, $replyToMessageId = null, $replyMarkup = null) {
        $data = [
            'chat_id' => $chatId,
            'photo' => $photo
        ];
        
        if ($caption !== null) {
            $data['caption'] = $caption;
        }
        
        if ($replyToMessageId !== null) {
            $data['reply_to_message_id'] = $replyToMessageId;
        }
        
        if ($replyMarkup !== null) {
            $data['reply_markup'] = $replyMarkup;
        }
        
        return $this->callApi('sendPhoto', $data);
    }
    
    public function sendAudio($chatId, $audio, $caption = null, $replyToMessageId = null, $replyMarkup = null) {
        $data = [
            'chat_id' => $chatId,
            'audio' => $audio
        ];
        
        if ($caption !== null) {
            $data['caption'] = $caption;
        }
        
        if ($replyToMessageId !== null) {
            $data['reply_to_message_id'] = $replyToMessageId;
        }
        
        if ($replyMarkup !== null) {
            $data['reply_markup'] = $replyMarkup;
        }
        
        return $this->callApi('sendAudio', $data);
    }
    
    public function sendDocument($chatId, $document, $caption = null, $replyToMessageId = null, $replyMarkup = null) {
        $data = [
            'chat_id' => $chatId,
            'document' => $document
        ];
        
        if ($caption !== null) {
            $data['caption'] = $caption;
        }
        
        if ($replyToMessageId !== null) {
            $data['reply_to_message_id'] = $replyToMessageId;
        }
        
        if ($replyMarkup !== null) {
            $data['reply_markup'] = $replyMarkup;
        }
        
        return $this->callApi('sendDocument', $data);
    }
    
    public function sendVideo($chatId, $video, $caption = null, $replyToMessageId = null, $replyMarkup = null) {
        $data = [
            'chat_id' => $chatId,
            'video' => $video
        ];
        
        if ($caption !== null) {
            $data['caption'] = $caption;
        }
        
        if ($replyToMessageId !== null) {
            $data['reply_to_message_id'] = $replyToMessageId;
        }
        
        if ($replyMarkup !== null) {
            $data['reply_markup'] = $replyMarkup;
        }
        
        return $this->callApi('sendVideo', $data);
    }
    
    public function sendAnimation($chatId, $animation, $replyToMessageId = null, $replyMarkup = null) {
        $data = [
            'chat_id' => $chatId,
            'animation' => $animation
        ];
        
        if ($replyToMessageId !== null) {
            $data['reply_to_message_id'] = $replyToMessageId;
        }
        
        if ($replyMarkup !== null) {
            $data['reply_markup'] = $replyMarkup;
        }
        
        return $this->callApi('sendAnimation', $data);
    }
    
    public function sendVoice($chatId, $voice, $caption = null, $replyToMessageId = null, $replyMarkup = null) {
        $data = [
            'chat_id' => $chatId,
            'voice' => $voice
        ];
        
        if ($caption !== null) {
            $data['caption'] = $caption;
        }
        
        if ($replyToMessageId !== null) {
            $data['reply_to_message_id'] = $replyToMessageId;
        }
        
        if ($replyMarkup !== null) {
            $data['reply_markup'] = $replyMarkup;
        }
        
        return $this->callApi('sendVoice', $data);
    }
    
    public function sendMediaGroup($chatId, $media, $replyToMessageId = null) {
        $data = [
            'chat_id' => $chatId,
            'media' => $media
        ];
        
        if ($replyToMessageId !== null) {
            $data['reply_to_message_id'] = $replyToMessageId;
        }
        
        return $this->callApi('sendMediaGroup', $data);
    }
    
    // Location & Contact
    public function sendLocation($chatId, $latitude, $longitude, $horizontalAccuracy = null, $replyToMessageId = null, $replyMarkup = null) {
        $data = [
            'chat_id' => $chatId,
            'latitude' => $latitude,
            'longitude' => $longitude
        ];
        
        if ($horizontalAccuracy !== null) {
            $data['horizontal_accuracy'] = $horizontalAccuracy;
        }
        
        if ($replyToMessageId !== null) {
            $data['reply_to_message_id'] = $replyToMessageId;
        }
        
        if ($replyMarkup !== null) {
            $data['reply_markup'] = $replyMarkup;
        }
        
        return $this->callApi('sendLocation', $data);
    }
    
    public function sendContact($chatId, $phoneNumber, $firstName, $lastName = null, $replyToMessageId = null, $replyMarkup = null) {
        $data = [
            'chat_id' => $chatId,
            'phone_number' => $phoneNumber,
            'first_name' => $firstName
        ];
        
        if ($lastName !== null) {
            $data['last_name'] = $lastName;
        }
        
        if ($replyToMessageId !== null) {
            $data['reply_to_message_id'] = $replyToMessageId;
        }
        
        if ($replyMarkup !== null) {
            $data['reply_markup'] = $replyMarkup;
        }
        
        return $this->callApi('sendContact', $data);
    }
    
    // Chat Actions
    public function sendChatAction($chatId, $action) {
        return $this->callApi('sendChatAction', [
            'chat_id' => $chatId,
            'action' => $action
        ]);
    }
    
    // File Methods
    public function getFile($fileId) {
        return $this->callApi('getFile', [
            'file_id' => $fileId
        ]);
    }
    
    // Update Methods
    public function getUpdates($offset = null, $limit = null, $timeout = null) {
        $data = [];
        
        if ($offset !== null) {
            $data['offset'] = $offset;
        }
        
        if ($limit !== null) {
            $data['limit'] = $limit;
        }
        
        if ($timeout !== null) {
            $data['timeout'] = $timeout;
        }
        
        return $this->callApi('getUpdates', $data);
    }
    
    // Webhook Methods
    public function setWebhook($url) {
        return $this->callApi('setWebhook', [
            'url' => $url
        ]);
    }
    
    public function deleteWebhook() {
        return $this->callApi('deleteWebhook');
    }
    
    public function getWebhookInfo() {
        return $this->callApi('getWebhookInfo');
    }
    
    // Callback Query
    public function answerCallbackQuery($callbackQueryId, $text = null, $showAlert = false) {
        $data = [
            'callback_query_id' => $callbackQueryId
        ];
        
        if ($text !== null) {
            $data['text'] = $text;
        }
        
        if ($showAlert) {
            $data['show_alert'] = true;
        }
        
        return $this->callApi('answerCallbackQuery', $data);
    }
    
    // Chat Management
    public function banChatMember($chatId, $userId) {
        return $this->callApi('banChatMember', [
            'chat_id' => $chatId,
            'user_id' => $userId
        ]);
    }
    
    public function unbanChatMember($chatId, $userId, $onlyIfBanned = false) {
        $data = [
            'chat_id' => $chatId,
            'user_id' => $userId
        ];
        
        if ($onlyIfBanned) {
            $data['only_if_banned'] = true;
        }
        
        return $this->callApi('unbanChatMember', $data);
    }
    
    public function promoteChatMember($chatId, $userId, $canChangeInfo = false, $canPostMessages = false, $canEditMessages = false, $canDeleteMessages = false, $canManageVideoChats = false, $canInviteUsers = false, $canRestrictMembers = false) {
        return $this->callApi('promoteChatMember', [
            'chat_id' => $chatId,
            'user_id' => $userId,
            'can_change_info' => $canChangeInfo,
            'can_post_messages' => $canPostMessages,
            'can_edit_messages' => $canEditMessages,
            'can_delete_messages' => $canDeleteMessages,
            'can_manage_video_chats' => $canManageVideoChats,
            'can_invite_users' => $canInviteUsers,
            'can_restrict_members' => $canRestrictMembers
        ]);
    }
    
    public function setChatPhoto($chatId, $photo) {
        return $this->callApi('setChatPhoto', [
            'chat_id' => $chatId,
            'photo' => $photo
        ]);
    }
    
    public function leaveChat($chatId) {
        return $this->callApi('leaveChat', [
            'chat_id' => $chatId
        ]);
    }
    
    public function getChat($chatId) {
        return $this->callApi('getChat', [
            'chat_id' => $chatId
        ]);
    }
    
    public function getChatMembersCount($chatId) {
        return $this->callApi('getChatMembersCount', [
            'chat_id' => $chatId
        ]);
    }
    
    // Message Management
    public function pinChatMessage($chatId, $messageId) {
        return $this->callApi('pinChatMessage', [
            'chat_id' => $chatId,
            'message_id' => $messageId
        ]);
    }
    
    public function unpinChatMessage($chatId, $messageId) {
        return $this->callApi('unpinChatMessage', [
            'chat_id' => $chatId,
            'message_id' => $messageId
        ]);
    }
    
    public function unpinAllChatMessages($chatId) {
        return $this->callApi('unpinAllChatMessages', [
            'chat_id' => $chatId
        ]);
    }
    
    // Chat Info Management
    public function setChatTitle($chatId, $title) {
        return $this->callApi('setChatTitle', [
            'chat_id' => $chatId,
            'title' => $title
        ]);
    }
    
    public function setChatDescription($chatId, $description) {
        return $this->callApi('setChatDescription', [
            'chat_id' => $chatId,
            'description' => $description
        ]);
    }
    
    public function deleteChatPhoto($chatId) {
        return $this->callApi('deleteChatPhoto', [
            'chat_id' => $chatId
        ]);
    }
    
    // Invite Links
    public function createChatInviteLink($chatId) {
        return $this->callApi('createChatInviteLink', [
            'chat_id' => $chatId
        ]);
    }
    
    public function revokeChatInviteLink($chatId, $inviteLink) {
        return $this->callApi('revokeChatInviteLink', [
            'chat_id' => $chatId,
            'invite_link' => $inviteLink
        ]);
    }
    
    public function exportChatInviteLink($chatId) {
        return $this->callApi('exportChatInviteLink', [
            'chat_id' => $chatId
        ]);
    }
    
    // Message Editing
    public function editMessageText($chatId, $messageId, $text, $replyMarkup = null) {
        $data = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => $text
        ];
        
        if ($replyMarkup !== null) {
            $data['reply_markup'] = $replyMarkup;
        }
        
        return $this->callApi('editMessageText', $data);
    }
    
    public function editMessageCaption($chatId, $messageId, $caption = null, $replyMarkup = null) {
        $data = [
            'chat_id' => $chatId,
            'message_id' => $messageId
        ];
        
        if ($caption !== null) {
            $data['caption'] = $caption;
        }
        
        if ($replyMarkup !== null) {
            $data['reply_markup'] = $replyMarkup;
        }
        
        return $this->callApi('editMessageCaption', $data);
    }
    
    public function deleteMessage($chatId, $messageId) {
        return $this->callApi('deleteMessage', [
            'chat_id' => $chatId,
            'message_id' => $messageId
        ]);
    }
    
    // Stickers
    public function uploadStickerFile($userId, $sticker) {
        return $this->callApi('uploadStickerFile', [
            'user_id' => $userId,
            'sticker' => $sticker
        ]);
    }
    
    public function createNewStickerSet($userId, $name, $title, $stickers) {
        return $this->callApi('createNewStickerSet', [
            'user_id' => $userId,
            'name' => $name,
            'title' => $title,
            'stickers' => $stickers
        ]);
    }
    
    public function addStickerToSet($userId, $name, $sticker) {
        return $this->callApi('addStickerToSet', [
            'user_id' => $userId,
            'name' => $name,
            'sticker' => $sticker
        ]);
    }
    
    // Payments
    public function sendInvoice($chatId, $title, $description, $payload, $providerToken, $prices, $photoUrl = null, $replyToMessageId = null) {
        $data = [
            'chat_id' => $chatId,
            'title' => $title,
            'description' => $description,
            'payload' => $payload,
            'provider_token' => $providerToken,
            'prices' => $prices
        ];
        
        if ($photoUrl !== null) {
            $data['photo_url'] = $photoUrl;
        }
        
        if ($replyToMessageId !== null) {
            $data['reply_to_message_id'] = $replyToMessageId;
        }
        
        return $this->callApi('sendInvoice', $data);
    }
    
    public function createInvoiceLink($title, $description, $payload, $providerToken, $prices) {
        return $this->callApi('createInvoiceLink', [
            'title' => $title,
            'description' => $description,
            'payload' => $payload,
            'provider_token' => $providerToken,
            'prices' => $prices
        ]);
    }
    
    public function answerPreCheckoutQuery($preCheckoutQueryId, $ok, $errorMessage = null) {
        $data = [
            'pre_checkout_query_id' => $preCheckoutQueryId,
            'ok' => $ok
        ];
        
        if (!$ok && $errorMessage !== null) {
            $data['error_message'] = $errorMessage;
        }
        
        return $this->callApi('answerPreCheckoutQuery', $data);
    }
    
    public function inquireTransaction($transactionId) {
        return $this->callApi('inquireTransaction', [
            'transaction_id' => $transactionId
        ]);
    }
}

?>