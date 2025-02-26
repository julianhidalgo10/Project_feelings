<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NotificacionService;
use Illuminate\Support\Facades\Log;

class NotificacionController extends Controller
{
    protected $notificacionService;

    public function __construct(NotificacionService $notificacionService)
    {
        $this->notificacionService = $notificacionService;
    }

    public function enviarNotificacion(Request $request)
    {
        // 📌 Log para ver qué datos recibe Laravel
        Log::info('📩 Datos recibidos en Laravel:', $request->all());

        // 📌 Validación de la solicitud
        try {
            $validated = $request->validate([
                'mensaje' => 'required|string',
                'telefono' => 'required|string',
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error de validación:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Datos inválidos. Asegúrate de enviar "mensaje" y "telefono" como strings.'], 400);
        }

        // 📌 Llamar al servicio para enviar el SMS
        try {
            $resultado = $this->notificacionService->registrarNotificacion(
                $validated['mensaje'],
                $validated['telefono']
            );
        } catch (\Exception $e) {
            Log::error('❌ Error en el servicio de notificación:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error en el servicio de notificación.'], 500);
        }

        // 📌 Log para ver qué devuelve Laravel
        Log::info('📤 Respuesta de Laravel:', $resultado);

        return response()->json($resultado, 200);
    }
}