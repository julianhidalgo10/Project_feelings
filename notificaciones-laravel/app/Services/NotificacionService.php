<?php

namespace App\Services;

use Twilio\Rest\Client;
use App\Models\Notificacion;

class NotificacionService
{
    protected $twilio;
    protected $from;

    public function __construct()
    {
        $this->twilio = new Client(config('twilio.sid'), config('twilio.token'));
        $this->from = config('twilio.from');
    }

    public function enviarSMS($mensaje, $telefono)
    {
        try {
            $this->twilio->messages->create($telefono, [
                'from' => $this->from,
                'body' => $mensaje
            ]);

            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
            return false;
        }
    }

    public function registrarNotificacion($mensaje, $telefono)
    {
        $enviado_sms = $this->enviarSMS($mensaje, $telefono);

        Notificacion::create([
            'mensaje' => $mensaje,
            'telefono' => $telefono,
            'enviado_por_sms' => $enviado_sms,
            'enviado_en' => now(),
        ]);

        return [
            'sms' => $enviado_sms
        ];
    }
}