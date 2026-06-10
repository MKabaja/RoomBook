<?php

declare(strict_types=1);

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

uses(RefreshDatabase::class);
abstract class TestCase extends BaseTestCase
{
    public User $user;

    public string $token;
}
