<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private UserRepository $users
    ) {}

    public function index()
    {
        return response()->json($this->users->all());
    }

    public function show(int $id)
    {
        $user = $this->users->find($id);

        return $user
            ? response()->json($user)
            : response()->json(['message' => 'Usuario no encontrado'], 404);
    }

    public function store(UserRequest $request)
    {
        $user = $this->users->create($request->validated());

        return response()->json($user, 201);
    }

    public function update(UserRequest $request, int $id)
    {
        $user = $this->users->update($id, $request->validated());

        return response()->json($user);
    }
}
