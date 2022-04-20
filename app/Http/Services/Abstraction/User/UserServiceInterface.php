<?php

namespace App\Http\Services\Abstraction\User;

use App\Models\User;

/**
 * Class UserServiceInterface
 *
 * @package App\Http\Services\Abstraction\User
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
interface UserServiceInterface
{
    /**
     * Insert user.
     *
     * @param array $request
     *
     * @return array
     */
    public function store(array $request): array;

    /**
     * Update user.
     *
     * @param array $data
     * @param $userId
     *
     * @return void
     */
    public function update(array $data, $userId): void;

    /**
     * Get user by email an password
     *
     * @param array $request
     *
     * @return \App\Models\User
     */
    public function getByEmailAndPassword(array $request): User;

    /**
     * Get user by email
     *
     * @param string $email
     *
     * @return User
     */
    public function getByEmail(string $email): User;
}