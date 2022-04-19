<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 19.4.2022.
 * Time: 18:51
 */

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;
use Tests\TestCase;

class RoleTest extends TestCase
{
    public function test_role_all()
    {
        $user = User::factory()->make([
            'password' => 'Test123!'
        ]);

        Passport::actingAs($user);

        $response = $this->get('/api/users/roles');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            "success" => [
                "data",
                "message"
            ]
        ]);
    }
}