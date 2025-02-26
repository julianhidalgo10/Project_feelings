<?php

return [
    'sid' => env('TWILIO_SID'),
    'token' => env('TWILIO_AUTH_TOKEN'),
    'from' => env('TWILIO_PHONE'),
    'admin_phone' => env('ADMIN_PHONE'),
];