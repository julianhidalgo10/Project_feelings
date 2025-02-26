<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificacionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar rutas para la API de Laravel. Estas rutas 
| están cargadas por el RouteServiceProvider y todas estarán dentro del 
| grupo de middleware "api".
|
*/

// 📌 Ruta de prueba para verificar que Laravel está respondiendo
Route::get('/notificacion/test', function () {
    return response()->json(["message" => "La API esta funcionando correctamente"], 200);
});

// 📌 Ruta principal para enviar notificaciones vía SMS con Twilio
Route::post('/notificacion', [NotificacionController::class, 'enviarNotificacion']);