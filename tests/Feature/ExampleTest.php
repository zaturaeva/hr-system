<?php
// tests/Feature/ExampleTest.php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_application_returns_a_successful_response(): void
    {
        // Главная страница перенаправляет на /employees
        $response = $this->get('/');
        
        // Проверяем, что это редирект (302)
        $response->assertStatus(302);
        
        // Или проверяем, что редирект ведёт на /employees
        $response->assertRedirect('/employees');
    }
}
