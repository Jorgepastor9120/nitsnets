<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberStoreRequest;
use App\Http\Requests\MemberUpdateApiRequest;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Mostramos el listado de los socios solicitados.
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *    path="/api/v1/members",
     *    tags={"Members"},
     *    summary="Mostrar el listado de socios",
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

    public function index(Member $member)
    {
        return $member->get();
    }

    /**
     * Registrar un socio.
     * @return \Illuminate\Http\Response
     *
     * @OA\Post(
     *    path="/api/v1/members",
     *    tags={"Members"},
     *    summary="Registra un socio",
     *    @OA\RequestBody(
     *       required=true,
     *       description="Registra un socio",
     *       @OA\JsonContent(
     *           required={"name", "email"},
     *           @OA\Property(
     *               property="name", type="string", format="text", example="Prueba"
     *           ),
     *           @OA\Property(
     *               property="email", type="string", format="text", example="prueba@gmail.com"
     *           ),
     *       ),
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="OK"
     *    ),
     *    @OA\Response(
     *        response=201,
     *        description="El socio ha sido creado"
     *    ),
     *    @OA\Response(
     *        response=404,
     *        description="No se ha podido registrar el socio."
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
    public function store(MemberStoreRequest $request)
    {
        $createMember = Member::create(
            [
                'name' => $request->name,
                'email' => $request->email,
            ]);

        if (!$createMember) {
            return response([
                'message' => 'La creación ha fallado'
            ], 404);
        }
    
        return $createMember;
    }

    /**
     * Actualizar un registro.
     * @return \Illuminate\Http\Response
     *
     * @OA\Put(
     *    path="/api/v1/members/{id}",
     *    tags={"Members"},
     *    summary="Actualiza un socio",
     *    @OA\RequestBody(
     *        required=true,
     *        description="Actualiza un socio",
     *        @OA\JsonContent(
     *           required={"name", "email"},
     *           @OA\Property(
     *               property="name", type="string", format="text", example="Prueba"
     *           ),
     *           @OA\Property(
     *               property="email", type="string", format="text", example="prueba@gmail.com"
     *           ),
     *       ),
     *    ),
     *    @OA\Parameter(
     *        name="id", in="path", required=true, description="Id member",
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
     *        response=405,
     *        description="No se ha permitido actualizar el registro."
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
    public function update(MemberUpdateApiRequest $request, int $id)
    {
        $member = Member::findOrFail($id);

        $member->update(
            [
                'name' => $request->name,
                'email' => $request->email
            ]);

        if (!$request) {
            return response([
                'message' => 'Acción no permitida'
            ], 405);
        }

        return $member;
    }

    /**
     * Elimina un registro.
     * @return \Illuminate\Http\Response
     *
     * @OA\Delete(
     *    path="/api/v1/members/{id}",
     *    tags={"Members"},
     *    summary="Elimina un socio",
     *    @OA\RequestBody(
     *       description="Elimina un socio"
     *    ),
     *    @OA\Parameter(
     *        name="id", in="path", required=true, description="Id member",
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
        $member = Member::findorFail($id);

        $member->delete();

        if (!$member) {
            return response([
                'message' => 'No se encontró el socio con el ID especificado'
            ], 404);
        }

        return response([
            'message' => 'Socio eliminado'
        ], 200);
    }
}
