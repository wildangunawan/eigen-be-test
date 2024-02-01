<?php

namespace Tests\Feature\Book;

use Tests\TestCase;

class IndexTest extends TestCase
{
    public function testBasic()
    {
        $response = $this->get('/api/v1/books');
        $response->assertStatus(200);
    }
}
