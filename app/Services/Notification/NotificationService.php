<?php

namespace App\Services\Notification;

use App\Services\Notification\Campaing;

use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\FcmOptions;
use Kreait\Firebase\Messaging\MessageTarget;

use Exception;

class NotificationService
{
    // Validates maximun size on 'data' key in message, on: https://firebase.google.com/docs/cloud-messaging/concept-options#notifications_and_data_messages
    private const MAX_MESSAGE_PAYLOAD_SIZE_BYTES = 4000;

    private Messaging $messaging;

    public function __construct()
    {
        // Injected via app helper
        $this->messaging = app('firebase.messaging');
    }

    public function sendCampaing(Campaing $data, string | null $token): array
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

        $campaignId = uniqid('campaign-');
        $notificationId = uniqid('notification-');
        $dateNow = date('Y-m-d h:i:s');

        // Buidl FCM options for Analytics data
        $fcmOptions = FcmOptions::create()
            ->withAnalyticsLabel($campaignId);

        $cloudMessageTargetType = $token ? MessageTarget::TOKEN : MessageTarget::TOPIC;
        $cloudMessageTarget = $token ?? $defaultCampaignTopic;

        // Build cloud message
        $cloudMessage = CloudMessage::withTarget($cloudMessageTargetType, $cloudMessageTarget)
            ->withNotification($cloudCampaign)
            // Example additional data
            ->withData([
                'created_at' => $dateNow,
                'notification_id' => $notificationId,
                'campaign_id' => $campaignId,
                // Appends itself message for data message support
                ...$cloudCampaign->jsonSerialize()
            ])
            ->withFcmOptions($fcmOptions)
            ->withHighestPossiblePriority()
            ->withAndroidConfig(AndroidConfig::fromArray([
                'notification' => [
                    'image' => $data->image
                ]
            ]));

        $this->validatePayloadSize($cloudMessage);

        return $this->messaging->send($cloudMessage);
    }

    /**
     * @param CloudeMessage $cloudMessage
     * @throws Exception
     */
    private function validatePayloadSize(CloudMessage $cloudMessage)
    {
        // Extract payload
        ['data' => $data] = $cloudMessage->jsonSerialize();

        $isIn = strlen(json_encode($data)) <= self::MAX_MESSAGE_PAYLOAD_SIZE_BYTES;

        if (!$isIn) {
            throw new Exception("Message payload size exceded");
        }
    }
}
