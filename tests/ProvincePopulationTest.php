<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Models\Province;

class ProvincePopulationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Setup code to run before each test, if needed
    }

    public function testGetPopulationByCode()
    {
        // Assuming a province with code '01' exists in the JSON file
        $population = Province::getPopulationByCode('01');
        $this->assertNotNull($population);
        $this->assertIsNumeric($population);
    }

    public function testUpdatePopulation()
    {
        // Assuming a province with code '01' exists in the JSON file
        $newPopulation = 500000;
        Province::updatePopulation('01', $newPopulation);
        $this->assertEquals($newPopulation, Province::getPopulationByCode('01'));
    }
}
