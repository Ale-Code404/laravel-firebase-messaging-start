<?php

namespace App\Services\Notification;

use App\Services\Notification\Campaing;

use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\MessageTarget;

class NotificationService
{
    private Messaging $messaging;

    public function __construct()
    {
        // Injected via app helper
        $this->messaging = app('firebase.messaging');
    }

    public function sendCampaing(Campaing $data, string | null $token)
    {
        // Clients have to subscribe to topic via app or server
        $defaultCampaignTopic = 'marketing';

        /**
         * Client could be subcribed with this, example on update or create model
         * $this->messaging->subscribeToTopic($defaultCampaignTopic, $token)
         */

        $cloudCampaign = Notification::create(
            ucfirst($data->title),
            ucfirst($data->description),
            $data->image
        );

        if ($token) {
            $cloudMessage = CloudMessage::withTarget(MessageTarget::TOKEN, $token)
                ->withNotification($cloudCampaign)
                // Example additional data
                ->withData([
                    'created_at' => date('Y-m-d h:i:s'),
                    'notification_id' => uniqid('notification-'),
                    'campaign_id' => uniqid('campaign-')
                ]);
        } else {
            $cloudMessage = CloudMessage::withTarget(MessageTarget::TOPIC, $defaultCampaignTopic)
                ->withNotification($cloudCampaign)
                // Example additional data
                ->withData([
                    'created_at' => date('Y-m-d h:i:s'),
                    'notification_id' => uniqid('notification-'),
                    'campaign_id' => uniqid('campaign-')
                ]);
        }

        $response = $this->messaging->send($cloudMessage);

        // For debugging
        // \dd(compact('cloudMessage', 'response'));
    }
}
