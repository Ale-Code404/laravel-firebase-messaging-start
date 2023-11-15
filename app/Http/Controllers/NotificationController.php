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

        try {
            $service->sendCampaing($campaing, $data['token']);

            return redirect()
                ->route('notifications.campaings.form')
                ->with('notification.send.success', 'Campaña enviada correctamente');
        } catch (Exception $e) {
            return redirect()
                ->route('notifications.campaings.form')
                ->with('notification.send.fail', $e->getMessage());
        }
    }
}
