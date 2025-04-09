<?php

namespace app\Traits;


trait NotificationTrait
{
    function sendNotification($notifyDetails)
    {
        if ($notifyDetails['deviceType'] == config('constants.android')) {
            $fields = array(
                'registration_ids' => [$notifyDetails['deviceToken']],
                'priority' => 'high',
                'data' => [
                    'title' => $notifyDetails['title'],
                    'message' => $notifyDetails['msg'],
                    'userId' => $notifyDetails['userId'],
                    'body' => $notifyDetails['msg'],
                    'date' => $notifyDetails['date'],
                    'sound' => 'default',
                    "content_available" => true
                ]
            );
        } else {
            $fields = array(
                'registration_ids' => [$notifyDetails['deviceToken']],
                'priority' => 'high',
                'notification' => [
                    'title' => $notifyDetails['title'],
                    'message' => $notifyDetails['msg'],
                    'body' => $notifyDetails['msg'],
                    'userId' => $notifyDetails['userId'],
                    'date' => $notifyDetails['date'],
                    'sound' => 'default',
                    "content_available" => true
                ]
            );
        }
        // dd($fields);
        $headers = array(
            config('constants.fcmKey'),
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);

        curl_close($ch);
        //return $result;
        if ($result === false) {
            return false;
        } else {
            return true;
        }
    }

    function bulkNotification($deviceToken, $notifyDetails, $deviceType)
    {
        $fields = array();

        if ($deviceType == 'IOS') {
            $fields = array(
                'registration_ids' => $deviceToken['token'],
                'priority' => 'high',
                'notification' => [
                    'userId' => $deviceToken['userId'],
                    'title' => $notifyDetails['title'],
                    'message' => $notifyDetails['message'],
                    'notifyType' => $notifyDetails['notifyType'],
                    'sound' => 'default'
                ]
            );
        } elseif ($deviceType == 'ANDROID') {
            $fields = array(
                'registration_ids' => $deviceToken['token'],
                'priority' => 'high',
                'data' => [
                    'userId' => $deviceToken['userId'],
                    'title' => $notifyDetails['title'],
                    'message' => $notifyDetails['message'],
                    'notifyType' => $notifyDetails['notifyType'],
                    'sound' => 'default'
                ]
            );
        }

        $headers = array(
            config('constants.fcmKey'),
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

        if ($result === false) {
            return false;
        } else {
            return true;
        }
    }
}
