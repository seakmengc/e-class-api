<?php

namespace Tests\Feature\Api\v1;

use App\Models\Identity;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\Feature\Traits\PrepareForFeatureTesting;

class AuthTest extends TestCase
{
    use RefreshDatabase, PrepareForFeatureTesting, WithFaker;

    public function testRegister()
    {
        Storage::fake('local');

        $data = [
            "username" => "corwin.dandre",
            "email" => "kemmer.wendy@example.org",
            "phone_number" => "364-778-7367",
            "password" => "password",
            "password_confirmation" => "password",
            "first_name" => "Malachi",
            "last_name" => "King",
            "gender" => "others",
            'photo' => UploadedFile::fake()->image('abc.jpg')
        ];

        $this->postJson('/v1/register', $data)->assertCreated();
    }

    public function testLogin()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $data = [
            'identity' => $user->username,
            'password' => 'password',
        ];

        $this->postJson('v1/login', $data)->assertOk();
    }
}
