<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;


class UserController extends Controller
{
    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function register(RegisterRequest $request): JsonResponse | RedirectResponse
    {
        $validated = $request->validated();

        $avatarPath = $validated['avatar'];
        $avatarEncoded = base64_encode(file_get_contents($avatarPath->getRealPath()));

        $userData = [
            'id' => uniqid('', true),
            'nickname' => $validated['nickname'],
            'avatar' => $avatarEncoded,
            'created_at' => now()->toISOString(),
        ];

        try {
            // Check if user with this nickname already exists
            $allUsers = Redis::hgetall('users');
            foreach ($allUsers as $user) {
                $userDataExisting = json_decode($user, true);
                if (isset($userDataExisting['nickname']) && $userDataExisting['nickname'] === $userData['nickname']) {
                    return response()->json("User with nickname '{$userData['nickname']}' already exists", ResponseAlias::HTTP_FORBIDDEN);
                }
            }

            // Store the user
            $userExists = Redis::hset('users', $userData['id'], json_encode($userData, JSON_THROW_ON_ERROR));
            if (!$userExists){
                throw new RuntimeException("Failed to store user data");
            }
        } catch (Throwable $e){
            throw new RuntimeException("UserData store failure. " . $e->getMessage());
        }

        if ($request->input('_token') !== null){
            return back();
        }

        return response()->json('ok', ResponseAlias::HTTP_CREATED);
    }


    /**
     * Display all users.
     *
     * @return View
     */
    public function index()
    {
        try {
            $users = Redis::hgetall('users');

            // Convert the data from Redis to a proper array structure
            $userList = [];
            foreach ($users as $id => $userData) {
                $userList[] = json_decode($userData, true);
            }

            return view('users', ['users' => $userList]);
        } catch (Throwable $e) {
            throw new RuntimeException("Failed to retrieve users. $e");
        }
    }
}
