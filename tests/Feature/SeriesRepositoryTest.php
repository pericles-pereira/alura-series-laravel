<?php

namespace Tests\Feature;

use App\Repositories\SeriesRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SeriesRepositoryTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_when_a_series_is_created_its_seasons_and_episodes_must_also_be_created(): void
    {
        // Arrange
        $repository = $this->app->make(SeriesRepository::class);
        $data = [1, 'Nome da série', 1, 1];
        
        // Act
        $repository->add($data);

        // Assert
        $this->assertDatabaseHas('series', ['nome' => 'Nome da série']);
        $this->assertDatabaseHas('seasons', ['number' => 1]);
        $this->assertDatabaseHas('episodes', ['number' => 1]);

    }
}
