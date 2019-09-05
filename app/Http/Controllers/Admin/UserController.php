<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Services\Admin\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
     /**
     * @var UserService
     */
    protected $userService;

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * list all user
     *
     * @return JsonResponse
     */
    public function index()
    {
        $this->authorize('view', User::class);
        $users = $this->userService->get_list_users();

        return response()->json(
            [ 'listUser' => $users ], 200
        );
    }

    /**
     * list all user
     *
     * @return JsonResponse
     */
    public function store(UserRequest $request)
    {
        $this->authorize('create', User::class);
        $users = $this->userService->create_user($request->all());

        return response()->json(
            [
                'message' => trans('auth.create_success'),
                'user' => $users
            ], 200
        );
    }

   /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @param  User  $user
     *
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $response = $this->userService->edit_user($request->all(), $user);

        return response()->json(
            [
                'message' => $response ? trans('auth.update_success') : trans('auth.update_fail')
            ], 200 );
    }

    /**
     * delete user
     *
     * @param  User  $user
     *
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $response = $this->userService->delete_user($user);

        return response()->json(
            [
                'message' => $response ? trans('auth.delete_success') : trans('auth.delete_fail')
            ], 200 );
    }
}
