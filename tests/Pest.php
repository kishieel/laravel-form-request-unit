<?php

uses(\Orchestra\Testbench\TestCase::class, \Kishieel\RequestUnit\FormRequestValidator::class)->in(__DIR__);

/**
 * Set the currently logged in user for the application.
 *
 * @param \Illuminate\Contracts\Auth\Authenticatable $user
 * @param string|null $driver
 *
 * @return \Orchestra\Testbench\Contracts\TestCase
 */
function actingAs(\Illuminate\Contracts\Auth\Authenticatable $user, string $driver = null): \Orchestra\Testbench\Contracts\TestCase
{
    return test()->actingAs($user, $driver);
}
