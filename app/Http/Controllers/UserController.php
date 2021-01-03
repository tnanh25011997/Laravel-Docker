<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/users",
     *     security={{"bearerAuth":{}}},
     *     tags={"Users"},
     *     @OA\Response(response="200",
     *      description="User Collection.",
     *     ),
     *     @OA\Parameter(
     *      name="page",
     *      description="Pagination page",
     *      in="query",
     *      @OA\Schema (
     *          type="integer"
     *      )
     *     )
     * )
     */
    public function index(){

        \Gate::authorize('view','users');

        $user = User::paginate();
        //for collection
        return UserResource::collection($user);
    }

    /**
     * @OA\Get(
     *     path="/users/{id}",
     *     security={{"bearerAuth":{}}},
     *     tags={"Users"},
     *     @OA\Response(response="200",
     *      description="User.",
     *     ),
     *     @OA\Parameter(
     *      name="id",
     *      description="User ID",
     *      in="path",
     *      required=true,
     *      @OA\Schema (
     *          type="integer"
     *      )
     *     )
     * )
     */

    public function show($id){
        $user = User::find($id);
        //for 1 element
        return new UserResource($user);
    }

    /**
     * @OA\Post (
     *     path="/users",
     *     security={{"bearerAuth":{}}},
     *     tags={"Users"},
     *     @OA\Response(response="200",
     *      description="User",
     *     ),
     *     @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(ref="#/components/schemas/UserRequest")
     *     )
     * )
     */
    public function store(UserRequest $request){

        \Gate::authorize('edit','users');

        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role_id' => $request->input('role_id')
        ]);

        return response($user, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        \Gate::authorize('edit','users');
        $user = User::find($id);
        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role_id' => $request->input('role_id')
        ]);
        return response($user, Response::HTTP_ACCEPTED);
    }

    public function destroy($id){
        \Gate::authorize('edit','users');
        User::destroy($id);
        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function user(){

        return Auth::user();
    }

    public function updateInfo(Request $request){

        $user = Auth::user();
        $user->update($request->only('first_name','last_name','email'));
        return response($user, Response::HTTP_ACCEPTED);
    }

    public function updatePassword(Request $request){

        $user = Auth::user();
        $user->update([

            'password' => Hash::make($request->input('password'))
        ]);
        return response($user, Response::HTTP_ACCEPTED);
    }
}
