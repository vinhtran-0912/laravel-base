<?php
namespace App\Services\Admin;

use App\Models\User;
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
}
