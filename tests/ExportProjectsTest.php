<?php

namespace Lab36\ExcelReport\Tests;

use Faker\Factory;
use PHPUnit\Framework\TestCase;

class ExportProjectsTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();// TODO: Change the autogenerated stub
    }


    /** @test */
    public function should_get_project_data_from_collection()
    {
        $faker = Factory::create();

        $project_data = collect([
            [
                'project' => $faker->lastName,
                'start_date' => $faker->date('Y-m-d'),
                'cost' => $faker->numberBetween(2500, 3000),
                'type' => $faker->numberBetween(0, 3),
                'state'=> $faker->numberBetween(0,1),
                'client_name'=>$faker->name,
                'client_address'=>$faker->address,
            ],
            [
                'project' => $faker->lastName,
                'start_date' => $faker->date('Y-m-d'),
                'cost' => $faker->numberBetween(1000, 2000),
                'type' => $faker->numberBetween(0, 3),
                'state'=> $faker->numberBetween(0,1),
                'client_name'=>$faker->name,
                'client_address'=>$faker->address,
            ],
            [
                'project' => $faker->lastName,
                'start_date' => $faker->date('Y-m-d'),
                'cost' => $faker->numberBetween(4200, 4500),
                'type' => $faker->numberBetween(0, 3),
                'state'=> $faker->numberBetween(0,1),
                'client_name'=>$faker->name,
                'client_address'=>$faker->address,
            ],
            [
                'project' => $faker->lastName,
                'start_date' => $faker->date('Y-m-d'),
                'cost' => $faker->numberBetween(2200, 3500),
                'type' => $faker->numberBetween(0, 3),
                'state'=> $faker->numberBetween(0,1),
                'client_name'=>$faker->name,
                'client_address'=>$faker->address,
            ],
            [
                'project' => $faker->lastName,
                'start_date' => $faker->date('Y-m-d'),
                'cost' => $faker->numberBetween(4200, 4500),
                'type' => $faker->numberBetween(0, 3),
                'state'=> $faker->numberBetween(0,1),
                'client_name'=>$faker->name,
                'client_address'=>$faker->address,
            ],
            [
                'project' => $faker->lastName,
                'start_date' => $faker->date('Y-m-d'),
                'cost' => $faker->numberBetween(3200, 4500),
                'type' => $faker->numberBetween(0, 3),
                'state'=> $faker->numberBetween(0,1),
                'client_name'=>$faker->name,
                'client_address'=>$faker->address,
            ],
        ]);


        $file = ProjectDetailsExcelReport::fromCollection('Projects data', $project_data)->store('Projects data', __DIR__);
        $this->assertFileExists(__DIR__.'/'.$file);
    }

    /** @test */
    public function should_get_project_data_with_filters_from_collection()
    {
        $faker = Factory::create();

        $filters['project'] = 'c';
        $filters['state'] = 1;
        $filters['client_name'] = 'a';

        $project_data = collect([
            [
                'project' => $faker->lastName,
                'start_date' => $faker->date('Y-m-d'),
                'cost' => $faker->numberBetween(2500, 3000),
                'type' => $faker->numberBetween(0, 3),
                'state'=> $faker->numberBetween(0,1),
                'client_name'=>$faker->name,
                'client_address'=>$faker->address,
            ],
            [
                'project' => $faker->lastName,
                'start_date' => $faker->date('Y-m-d'),
                'cost' => $faker->numberBetween(1000, 2000),
                'type' => $faker->numberBetween(0, 3),
                'state'=> $faker->numberBetween(0,1),
                'client_name'=>$faker->name,
                'client_address'=>$faker->address,
            ],
            [
                'project' => $faker->lastName,
                'start_date' => $faker->date('Y-m-d'),
                'cost' => $faker->numberBetween(4200, 4500),
                'type' => $faker->numberBetween(0, 3),
                'state'=> $faker->numberBetween(0,1),
                'client_name'=>$faker->name,
                'client_address'=>$faker->address,
            ],
            [
                'project' => $faker->lastName,
                'start_date' => $faker->date('Y-m-d'),
                'cost' => $faker->numberBetween(4200, 4500),
                'type' => $faker->numberBetween(0, 3),
                'state'=> $faker->numberBetween(0,1),
                'client_name'=>$faker->name,
                'client_address'=>$faker->address,
            ],
            [
                'project' => $faker->lastName,
                'start_date' => $faker->date('Y-m-d'),
                'cost' => $faker->numberBetween(4200, 4500),
                'type' => $faker->numberBetween(0, 3),
                'state'=> $faker->numberBetween(0,1),
                'client_name'=>$faker->name,
                'client_address'=>$faker->address,
            ],
            [
                'project' => $faker->lastName,
                'start_date' => $faker->date('Y-m-d'),
                'cost' => $faker->numberBetween(4200, 4500),
                'type' => $faker->numberBetween(0, 3),
                'state'=> $faker->numberBetween(0,1),
                'client_name'=>$faker->name,
                'client_address'=>$faker->address,
            ],
        ]);


        $file = ProjectDetailsExcelReport::fromCollection('Projects data with filters', $project_data)
                                         ->setFilters($filters)
                                         ->store('Projects data with filters', __DIR__);
        $this->assertFileExists(__DIR__.'/'.$file);
    }
}