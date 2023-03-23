<?php

namespace Tests\Unit\Models;

use App\Models\Court;
use App\Models\Sport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourtTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_belongs_to_sport(): void
    {
        $sport = Sport::create(
            [
                'name' => 'Sport example',
            ]);

        $court = Court::create(
            [
                'name' => 'Court example',
                'sport_id' => $sport->id
            ]);

        $this->assertInstanceOf(Sport::class, $court->sport);
    }
}
