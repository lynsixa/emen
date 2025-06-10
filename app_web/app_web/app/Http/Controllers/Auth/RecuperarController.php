<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Usuario;
use Illuminate\Support\Facades\Log;

class RecuperarController extends Controller
{
    // Mostrar formulario para escribir el correo
    public function showForm()
    {
        return view('auth.recupera');
    }

    // Enviar correo con link de recuperación
    public function enviarCorreo(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Buscar al usuario por correo
        $usuario = Usuario::where('Correo', $request->email)->first();

        // Si no se encuentra el usuario con ese correo
        if (!$usuario) {
            return back()->with('error', 'No se encontró un usuario con ese correo.');
        }

        DB::beginTransaction();
        try {
            // Marcar que se solicitó el cambio de contraseña
            $usuario->password_request = 1;

            // Generar un token seguro para la recuperación
            $token = Str::random(60);
            $usuario->token_password = $token;

            // Guardar los cambios en la base de datos
            $usuario->save();
            DB::commit();

            // Crear la URL del enlace de recuperación
            $url = url("/recuperar/cambiar/{$usuario->idUsuario}/{$token}");

            // Enviar el correo de recuperación
            try {
                Mail::send('emails.recuperacion', ['usuario' => $usuario, 'url' => $url], function ($message) use ($usuario) {
                    $message->to($usuario->Correo)
                            ->subject('Recuperar contraseña')
                            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                });

                // Si el correo se envía correctamente
                return redirect()->route('login')->with('mensaje', 'Se ha enviado el enlace de recuperación a tu correo.');
            } catch (\Exception $e) {
                // Si falla el envío del correo
                Log::error("Error al enviar el correo de recuperación: " . $e->getMessage());
                return back()->with('error', 'No se pudo enviar el correo de recuperación.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al procesar la solicitud de recuperación: ' . $e->getMessage());
            return back()->with('error', 'Error al procesar la solicitud: ' . $e->getMessage());
        }
    }

    // Mostrar formulario de cambio de contraseña desde el link
    public function cambiarForm($id, $token)
    {
        // Verificar si el token y el id corresponden al usuario
        $usuario = Usuario::where('idUsuario', $id)
                          ->where('token_password', $token)
                          ->where('password_request', 1)
                          ->first();

        // Si no se encuentra el usuario o el token es inválido, se aborta con un error
        if (!$usuario) {
            abort(404, 'Token inválido o expirado.');
        }

        // Mostrar la vista del formulario de cambio de contraseña con el id y el token
        return view('auth.cambiar_password', compact('id', 'token'));
    }

    // Guardar la nueva contraseña
    public function cambiarPassword(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'password' => 'required|confirmed|min:6', // Contraseña debe ser mínima de 6 caracteres
            'id' => 'required',
            'token' => 'required'
        ]);

        // Verificar si el token y el id corresponden al usuario
        $usuario = Usuario::where('idUsuario', $request->id)
                          ->where('token_password', $request->token)
                          ->where('password_request', 1)
                          ->first();

        // Si no se encuentra el usuario o el token es inválido, se muestra un error
        if (!$usuario) {
            return back()->with('error', 'Token inválido o expirado.');
        }

        try {
            // Actualizar la contraseña y limpiar el token
            $usuario->Contraseña = bcrypt($request->password); // Cifra la contraseña
            $usuario->token_password = null; // Eliminar el token de recuperación
            $usuario->password_request = 0; // Establecer que la solicitud de cambio fue completada
            $usuario->save(); // Guardar los cambios en la base de datos

            Log::info("Contraseña actualizada para el usuario ID: {$usuario->idUsuario}");

            // Redirigir al login con un mensaje de éxito
            return redirect()->route('login')->with('mensaje', 'Contraseña actualizada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar la contraseña: ' . $e->getMessage());
            return back()->with('error', 'No se pudo actualizar la contraseña.');
        }
    }
}
