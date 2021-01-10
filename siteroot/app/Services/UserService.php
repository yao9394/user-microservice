<?php
namespace App\Services;

use App\Models\User;
use App\Exceptions\CustomDbException;
use App\Exceptions\ObjectNotFoundException;
use Log;

class UserService {

    public function list()
    {
        try {
            $users = User::all();
        } catch (\Exception $e) {
            $this->throwDbException($e, 'Error when listing users');
        }

        return $users;
    }

    public function add($params)
    {
        $user = new User;
        try {
            return $user->create($params);
        } catch (\Exception $e) {
            $this->throwDbException($e, 'Error when creating a user');
        }
    }

    public function show($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            throw new ObjectNotFoundException('User does not exist');
        }

        return $user;
    }

    public function update($params, $userId)
    {
        $user = $this->show($userId);

        try {
            $user->fill($params);
            $user->save();
            return $user;
        } catch (\Exception $e) {
            $this->throwDbException($e, 'Error when updating a user');
        }
    }

    public function delete($userId)
    {
        $user = $this->show($userId);

        try {
            User::destroy($userId);
            return $user;
        } catch (\Exception $e) {
            $this->throwDbException($e, 'Error when deleting a user');
        }
    }

    private function throwDbException(\Exception $e, $message)
    {
        Log::debug($e);
        throw new CustomDbException($message);
    }
}