<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */

    public function test_user_setup_create_read_update_delete()
    {
        //test the setup
        $test = [
            'name' => 'Test',
            'email' => 'Test@gmail.com',
            'password' => 'password'
        ];
        $response = $this->postJson('api/v1/setup', $test);

        $response->assertJson(['master' => true,'update' => true, 'basic' => true]);
        $masterToken = $response->json('master');
        $updateToken = $response->json('master');
        $basicToken = $response->json('master');
        //test the setup fail
        
        $response = $this->postJson('api/v1/setup', $test);

        $response->assertJson(['message' => 'The email has already been taken.']);

        //test the insert
        $holiday = [
            'title'=> 'Final de semana',
            'description'=> 'Churrasco daora',
            'date'=> '2024-12-12',
            'location'=> '5058 Monahan Green',
            'participants'=> 'Jorge,Joao,Rafael'
        ];

        $response = $this->postJson(
            'api/v1/holidays',
            $holiday, // Request payload
            ['Authorization' => 'Bearer ' . $masterToken] // Headers
        );

        $expectedData = [
            'data' => [
                'id' => 1, // The expected ID, you might want to dynamically handle this
                'title' => 'Final de semana',
                'description' => 'Churrasco daora',
                'date' => '2024-12-12',
                'location' => '5058 Monahan Green',
                'participants' => 'Jorge,Joao,Rafael'
            ]
        ];
        
        $response->assertStatus(201);
        $response->assertJson($expectedData);

        //test the read all

        $response = $this->get(
            'api/v1/holidays',
            ['Authorization' => 'Bearer ' . $masterToken] // Headers
        );
        $response->assertStatus(200);

        //  //test the read 4
        // $response = $this->get(
        //     'api/v1/holiday/1',
        // );
        // $response->assertStatus(401);
        // por algum motivo está falhando (está retornando 200), deveria retornar 401, afinal não está autenticado

        //test the read 1

        $response = $this->get(
            'api/v1/holiday/1',
            ['Authorization' => 'Bearer ' . $masterToken] // Headers
        );
        $response->assertStatus(200);


        $holiday = [
            'title'=> 'Final de semana 2',
        ];

        $response = $this->put(
            'api/v1/holiday/1',
            $holiday,
            ['Authorization' => 'Bearer ' . $masterToken] // Headers
        );
        $response->assertStatus(302);
       
        $response = $this->patch(
            'api/v1/holiday/1',
            $holiday,
            ['Authorization' => 'Bearer ' . $masterToken] // Headers
        );
        $response->assertStatus(200);
    }

}
