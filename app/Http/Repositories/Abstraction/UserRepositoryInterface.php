<?php

namespace App\Http\Repositories\Abstraction;

use App\Models\User;

/**
 * Class UserRepositoryInterface
 *
 * @package App\Http\Repositories\Abstraction
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
interface UserRepositoryInterface
{
    /**
     * Insert user.
     *
     * @param array $user
     *
     * @return void
     */
    public function store(array $user): void;

    /**
     * Get user by email and password
     *
     * @param array $data
     *
     * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getByEmailAndPassword(array $data): User;

    /**
     * Get user by email
     *
     * @param string $email
     *
     * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getByEmail(string $email): User;

    /**
     * Update user.
     *
     * @param array $data
     * @param int $userId
     *
     * @return void
     */
    public function update(array $data, int $userId);
}