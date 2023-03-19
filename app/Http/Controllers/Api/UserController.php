<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Controllers\Api\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{

    /**
     * Mostramos el listado de los regitros solicitados.
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *    path="/api/v1/users",
     *    tags={"Users"},
     *    summary="Mostrar el listado de usuarios",
     *    security={{"passport": {}}},
     *    @OA\Response(
     *        response=200,
     *        description="OK",
     *        @OA\JsonContent()
     *    ),
     *    @OA\Response(
     *        response=404,
     *        description="No se ha podido cargar el listado."
     *    ),
     *    @OA\Response(
     *        response=503,
     *        description="El servidor no está disponible en este momento"
     *    ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     )
     * )
     */
    public function index(User $user)
    {
        return $user->get();
    }

    /**
     * Registrar un usuario.
     * @return \Illuminate\Http\Response
     *
     * @OA\Post(
     *    path="/api/v1/users",
     *    tags={"Users"},
     *    summary="Registra un usuario",
     *    security={{"passport": {}}},
     *    @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"name","email", "password", "password_confirmation"},
     *               @OA\Property(property="name", type="text"),
     *               @OA\Property(property="email", type="text"),
     *               @OA\Property(property="password", type="password"),
     *               @OA\Property(property="password_confirmation", type="password")
     *            ),
     *        ),
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="OK"
     *    ),
     *    @OA\Response(
     *        response=201,
     *        description="El usuario ha sido creado"
     *    ),
     *    @OA\Response(
     *        response=404,
     *        description="No se ha podido registrar el usuario."
     *    ),
     *    @OA\Response(
     *        response=503,
     *        description="El servidor no está disponible en este momento"
     *    ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (!$user) {
            return response([
                'message' => 'La creación ha fallado'
            ], 404);
        }

        return $user;
    }

    /**
     * Actualizar un registro.
     * @return \Illuminate\Http\Response
     *
     * @OA\Put(
     *    path="/api/v1/users/{id}",
     *    tags={"Users"},
     *    summary="Actualiza un usuario",
     *    security={{"passport": {}}},
     *    @OA\RequestBody(
     *        required=true,
     *        description="Actualiza un usuario",
     *        @OA\JsonContent(
     *           required={"name","email", "password", "password_confirmation"},
     *           @OA\Property(property="name", type="text", example="Prueba"),
     *           @OA\Property(property="email", type="text", example="prueba@gmail.com"),
     *           @OA\Property(property="password", type="password", example=""),
     *           @OA\Property(property="password_confirmation", type="password", example="")
     *       ),
     *    ),
     *    @OA\Parameter(
     *        name="id", in="path", required=true, description="Id user",
     *        @OA\schema(type="integer", format="int20")
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="OK"
     *    ),
     *    @OA\Response(
     *        response=404,
     *        description="No se ha podido actualizar el registro."
     *    ),
     *    @OA\Response(
     *        response=503,
     *        description="El servidor no está disponible en este momento"
     *    ),
     *    @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *    )
     * )
     */
    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        if (!$user) {
            return response([
                'message' => 'No se encontró el usuario con el ID especificado'
            ], 404);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $user;
    }

    /**
     * Elimina un registro.
     * @return \Illuminate\Http\Response
     *
     * @OA\Delete(
     *    path="/api/v1/users/{id}",
     *    tags={"Users"},
     *    summary="Elimina un usuario",
     *    security={{"passport": {}}},
     *    @OA\RequestBody(
     *       description="Elimina un usuario"
     *    ),
     *    @OA\Parameter(
     *        name="id", in="path", required=true, description="Id user",
     *        @OA\schema(type="integer", format="int20")
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="OK"
     *    ),
     *    @OA\Response(
     *        response=404,
     *        description="No se ha podido eliminar el registro."
     *    ),
     *    @OA\Response(
     *        response=503,
     *        description="El servidor no está disponible en este momento"
     *    ),
     *    @OA\Response(
     *        response="default",
     *        description="Ha ocurrido un error."
     *    )
     * )
     */
    public function destroy(int $id)
    {
        $user = User::findorFail($id);

        $user->delete();

        if (!$user) {
            return response([
                'message' => 'No se encontró el usuario con el ID especificado'
            ], 404);
        }

        return response([
            'message' => 'Usuario eliminado'
        ], 200);
    }
}