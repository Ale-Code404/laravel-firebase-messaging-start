<?php

namespace App\Http\Controllers;

use App\Services\Notification\Campaing;
use App\Services\Notification\NotificationService;
use Exception;
use Illuminate\Http\Request;

class NotificationController extends Controller

{
    /**
     * Create a marketing campaign sending via push notification on topic or token
     */
    public function createCampaign(Request $request, NotificationService $service)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'token' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        $campaing = new Campaing($data['title'], $data['description'], $data['image']);

        $redirect = redirect()
            ->route('notifications.campaings.form')
            ->withInput();

        try {
            $response = $service->sendCampaing($campaing, $data['token']);

            $redirect->with('notification.send.response', json_encode($response));

            return $redirect->with('notification.send.success', 'Notificación enviada correctamente');
        } catch (Exception $e) {
            return $redirect->with('notification.send.fail', $e->getMessage());
        }
    }
}
