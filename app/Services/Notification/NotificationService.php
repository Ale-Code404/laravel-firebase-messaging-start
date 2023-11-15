<?php

namespace App\Services\Notification;

use App\Services\Notification\Campaing;

use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\MessageTarget;
use stdClass;

class NotificationService
{
    private Messaging $messaging;

    public function __construct()
    {
        $this->messaging = app('firebase.messaging');
    }

    public function sendCampaing(Campaing $data, string $token)
    {
        $users = [
            ['name' => 'Usuario']
        ];

        foreach ($users as $user) {
            $cloudCampaign = Notification::create(
                "Hola {$user['name']}, " . \lcfirst($data->title),
                $data->description,
                $data->image
            );

            $cloudMessage = CloudMessage::withTarget(MessageTarget::TOKEN, $token)
                ->withNotification($cloudCampaign)
                // Example additional data
                ->withData([
                    'created_at' => \date('Y-m-d'),
                    'notification-id' => \uniqid('notification-')
                ]);

            $cloudMessages[] = $cloudMessage;
        }


        $response = $this->messaging->sendAll($cloudMessages);
    }
}
