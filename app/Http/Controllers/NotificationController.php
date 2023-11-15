<?php

namespace App\Http\Controllers;

use App\Services\Notification\Campaing;
use App\Services\Notification\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function createCampaign(Request $request, NotificationService $service)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|string',
            'token' => 'nullable|string',
        ]);

        $campaing = new Campaing($data['title'], $data['description'], $data['image']);

        $service->sendCampaing($campaing, $data['token']);
    }
}
