<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    public $baseUrl = "/api/v1/";

    public function setUp(): void
    {
    	parent::setUp();

    	$this->signIn();
    }

    public function signIn()
    {
    	Passport::actingAs(create('App\User'));
    } 
}
