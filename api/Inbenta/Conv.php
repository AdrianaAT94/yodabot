<?php
require_once __DIR__ . '/../Curl.php';
require_once __DIR__ . '/Auth.php';

class Conv {
    const URL = 'https://api-gce3.inbenta.io/prod/chatbot/v1/conversation';

    public static function getchatbotApiUrl($accessToken) {
        $result = Curl::get(
            'https://api.inbenta.io/v1/apis',
            array(
                'x-inbenta-key: ' .Auth::KEY,
                'Authorization: Bearer ' .$accessToken,
            ),
            ""
        );

        $res = json_decode($result);
        return $res->apis->chatbot;
    }

    public static function getConversationToken($accessToken) {
        $result = Curl::post(
            Conv::getchatbotApiUrl($accessToken).'/v1/conversation',
            array(
                'x-inbenta-key: ' .Auth::KEY,
                'Authorization: Bearer ' .$accessToken,
            ),
            ""
        );

        $res = json_decode($result);
        return $res->sessionToken;
    }

    public static function sendMsg($accessToken, $sessionToken, $msg) {
        $result = Curl::post(
            Conv::getchatbotApiUrl($accessToken).'/v1/conversation/message',
            array(
                'x-inbenta-key: ' . Auth::KEY,
                'Authorization: Bearer ' . $accessToken,
                'x-inbenta-session: Bearer ' . $sessionToken,
                'Content-Type: application/json',
            ),
            array(
                'message' => $msg,
            )
        );

        $res = json_decode($result);

        // error
        if (isset($res->errors)) {
            $sessionToken = Conv::getConversationToken($accessToken);
            $_SESSION['session_token'] = $sessionToken;
            return Conv::sendMsg($accessToken, $sessionToken, $msg);
        }

        // Msg deprecated
        $botMsg = '';
        foreach ($res->answers[0]->messageList as $value) {
            $botMsg .= htmlspecialchars($value) . '\n';
        }
        $botMsg = rtrim($botMsg, '\n');

        return array(
            'message' => $botMsg,
            'isNoResult' => in_array('no-results', $res->answers[0]->flags, true),
        );
    }

    public static function getTwoUnanswered($accessToken, $sessionToken) {
        $result = Curl::get(
            Conv::getchatbotApiUrl($accessToken).'/v1/conversation/variables',
            array(
                'x-inbenta-key: ' . Auth::KEY,
                'Authorization: Bearer ' . $accessToken,
                'x-inbenta-session: Bearer ' . $sessionToken,
                'Content-Type: application/json',
            ),
            array()
        );
		
		$res = json_decode($result);
        return intval($res->sys_unanswered_consecutive->value);
    }
}
