<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Admin\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
}
