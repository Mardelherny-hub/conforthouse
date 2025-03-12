<?php

namespace Tests;


use App\Models\Province;

class ProvinceTest extends \PHPUnit\Framework\TestCase
{
    public function testGetAllProvinces()
    {
        $provinces = Province::getAllProvinces();
        $this->assertIsArray($provinces);
        $this->assertNotEmpty($provinces);
    }

    public function testFindProvinceByCode()
    {
        $province = Province::findProvinceByCode('04');
        $this->assertNotNull($province);
        $this->assertEquals('Almería', $province['label']);
    }

    public function testAddProvince()
    {
        $newProvince = ['parent_code' => '01', 'code' => '99', 'label' => 'Test Province'];
        Province::addProvince($newProvince);
        $province = Province::findProvinceByCode('99');
        $this->assertNotNull($province);
        $this->assertEquals('Test Province', $province['label']);
    }

    public function testUpdateProvince()
    {
        $updatedData = ['label' => 'Updated Province'];
        Province::updateProvince('99', $updatedData);
        $province = Province::findProvinceByCode('99');
        $this->assertEquals('Updated Province', $province['label']);
    }

    public function testDeleteProvince()
    {
        Province::deleteProvince('99');
        $province = Province::findProvinceByCode('99');
        $this->assertNull($province);
    }
}
