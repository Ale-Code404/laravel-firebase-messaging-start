<?php

namespace App\Services\Notification;

class Campaing
{
    public function __construct(
        public string $title,
        public string $description,
        public string | null $image = null
    ) {
    }
}
