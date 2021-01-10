<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Events\UserStatus;

class UserController extends Controller
{
    protected $userRules = [
        'name'  => 'required|string',
		'email' => 'required|email|unique:users',
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return response()->json($this->user->list());
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->userRules);
        $user = $this->user->add($request->all());
        broadcast(new UserStatus($user, 'created'))->toOthers();

        return \response()->json($user, Response::HTTP_CREATED);
    }

    public function show($user)
    {
        $user = $this->user->show($user);
        return response()->json($user);
    }

    public function update(Request $request, $user)
    {
        $this->userRules['email'] = $this->userRules['email'] . ',email,' . $user;
        $this->validate($request, $this->userRules);
        $user = $this->user->update($request->all(), $user);
        broadcast(new UserStatus($user, 'updated'))->toOthers();

        return \response()->json($user, Response::HTTP_OK);
    }

    public function delete($user)
    {
        $user = $this->user->delete($user);
        broadcast(new UserStatus($user, 'removed'))->toOthers();

        return \response()->json($user, Response::HTTP_ACCEPTED);
    }
}