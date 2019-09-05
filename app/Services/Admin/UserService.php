<?php
namespace App\Services\Admin;

use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\LaravelBaseApiException;

class UserService
{
    /**
     *
     * @return JsonResponse
     */
    public function get_list_users()
    {
        $users = User::paginate(5);

        return response()->json($users);
    }


    /**
     *
     * @return JsonResponse
     */
    public function create_user($request)
    {
        $user = User::create($request)->assignRole(Role::MEMBER);

        return response()->json($user);
    }

     /**
     *
     * @return JsonResponse
     */
    public function edit_user($request, $user)
    {
        $response = $user->update($request);

        return $response;
    }

    /**
     *
     * @return JsonResponse
     */
    public function delete_user($user)
    {
        $response = $user->delete($user->id);

        return $response;
    }
}
