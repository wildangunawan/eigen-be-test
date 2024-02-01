<?php

namespace Tests\Feature\Member;

use Tests\TestCase;

class IndexTest extends TestCase
{
    public function testBasic()
    {
        $response = $this->getJson('/api/v1/members');
        $response->assertStatus(200);
    }
}
