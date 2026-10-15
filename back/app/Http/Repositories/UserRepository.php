<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function all(): Collection
    {
        return User::all();
    }

    public function find(int $id): ?User
    {
        return User::find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function create(array $data): User
    {
        $genres = $data['genres'] ?? [];
        unset($data['genres']);

        $data['profile_id'] = Profile::create()->id;

        $user = User::create($data);
        $user->genres()->sync($genres);

        return $user->load('profile', 'genres');
    }

    public function update(int $id, array $data): User
    {
        $user = User::findOrFail($id);
        $user->update($data);

        return $user;
    }

    public function delete(int $id): bool
    {
        return User::findOrFail($id)->delete();
    }
}
