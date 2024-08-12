<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */

    private function initial()
    {
        $test = [
            'name' => 'Test',
            'email' => 'Test@gmail.com',
            'password' => 'password'
        ];
        $response = $this->postJson('api/v1/setup', $test);
        $masterToken = $response->json('master');
        $basicToken = $response->json('basic');
        return ['master' => $masterToken, 'basic' => $basicToken];
    }

    public function test_user_setup()
    {
        $test = [
            'name' => 'Test',
            'email' => 'Test@gmail.com',
            'password' => 'password'
        ];
        $response = $this->postJson('api/v1/setup', $test);

        $response->assertJson(['master' => true,'update' => true, 'basic' => true]);
    }

    public function test_user_fail_setup()
    {
        $this->initial();

        $user = [
            'name' => 'Test',
            'email' => 'Test@gmail.com',
            'password' => 'password'
        ];
        $response = $this->postJson('api/v1/setup', $user);


        $response->assertJson(['message' => 'The email has already been taken.']);
    }
        
    public function test_holiday_insert()
    {
        $setup = $this->initial();

        $masterToken = $setup['master'];
        
        $holiday = [
            'title'=> 'Final de semana',
            'description'=> 'Churrasco daora',
            'date'=> '2024-12-12',
            'location'=> '5058 Monahan Green',
            'participants'=> 'Jorge,Joao,Rafael'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $masterToken,
        ])->postJson('api/v1/holidays', $holiday);

        $expectedData = [
            'data' => [
                'id' => 1, 
                'title' => 'Final de semana',
                'description' => 'Churrasco daora',
                'date' => '2024-12-12',
                'location' => '5058 Monahan Green',
                'participants' => 'Jorge,Joao,Rafael'
            ]
        ];
        
        $response->assertStatus(201);
        $response->assertJson($expectedData);
    }

    public function test_holiday_insert_fail_forbidden()
    {
        $setup = $this->initial();

        $basicToken = $setup['basic'];
        
        $holiday = [
            'title'=> 'Final de semana',
            'description'=> 'Churrasco daora',
            'date'=> '2024-12-12',
            'location'=> '5058 Monahan Green',
            'participants'=> 'Jorge,Joao,Rafael'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $basicToken,
        ])->postJson('api/v1/holidays', $holiday);

        $response->assertStatus(403);
    }

    public function test_holiday_insert_fail_unauth()
    {
        $holiday = [
            'title'=> 'Final de semana',
            'description'=> 'Churrasco daora',
            'date'=> '2024-12-12',
            'location'=> '5058 Monahan Green',
            'participants'=> 'Jorge,Joao,Rafael'
        ];

        $response = $this->withHeaders([
        ])->postJson('api/v1/holidays', $holiday);

        $response->assertStatus(401);
    }
    
    public function test_holiday_read_all()
    {
        $setup = $this->initial();

        $masterToken = $setup['master'];

        $holiday = [
            'title'=> 'Final de semana',
            'description'=> 'Churrasco daora',
            'date'=> '2024-12-12',
            'location'=> '5058 Monahan Green',
            'participants'=> 'Jorge,Joao,Rafael'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $masterToken,
        ])->postJson('api/v1/holidays', $holiday);

        $response = $this->get(
            'api/v1/holidays',
            ['Authorization' => 'Bearer ' . $masterToken] // Headers
        );
        $response->assertStatus(200);
    }

    public function test_holiday_read_one()
    {
        $setup = $this->initial();

        $masterToken = $setup['master'];
        
        $holiday = [
            'title'=> 'Final de semana',
            'description'=> 'Churrasco daora',
            'date'=> '2024-12-12',
            'location'=> '5058 Monahan Green',
            'participants'=> 'Jorge,Joao,Rafael'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $masterToken,
        ])->postJson('api/v1/holidays', $holiday);
        
        $response = $this->get(
            'api/v1/holiday/3',
            ['Authorization' => 'Bearer ' . $masterToken] // Headers
        );
        
        $response->assertStatus(200);
    }        

    public function test_holiday_update_fail_one()
    {
        $setup = $this->initial();

        $masterToken = $setup['master'];
       
        $holiday = [
            'title'=> 'Final de semana',
            'description'=> 'Churrasco daora',
            'date'=> '2024-12-12',
            'location'=> '5058 Monahan Green',
            'participants'=> 'Jorge,Joao,Rafael'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $masterToken,
        ])->postJson('api/v1/holidays', $holiday);

        $holidayUpdate = [
            'title'=> 'Final de semana 2',
        ];

        $response = $this->put(
            'api/v1/holiday/4',
            $holidayUpdate,
            ['Authorization' => 'Bearer ' . $masterToken] // Headers
        );
        $response->assertStatus(302);
    }    


    public function test_holiday_update_success()
    {
        $setup = $this->initial();

        $masterToken = $setup['master'];
        
        $holiday = [
            'title'=> 'Final de semana',
            'description'=> 'Churrasco daora',
            'date'=> '2024-12-12',
            'location'=> '5058 Monahan Green',
            'participants'=> 'Jorge,Joao,Rafael'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $masterToken,
        ])->postJson('api/v1/holidays', $holiday);

        $holidayUpdate = [
            'title'=> 'Final de semana 2',
        ];

        $response = $this->patch(
            'api/v1/holiday/5',
            $holidayUpdate,
            ['Authorization' => 'Bearer ' . $masterToken] // Headers
        );
        $response->assertStatus(200);
    }      

    public function test_holiday_delete_success()
    {
        $setup = $this->initial();

        $masterToken = $setup['master'];
        
        $holiday = [
            'title'=> 'Final de semana',
            'description'=> 'Churrasco daora',
            'date'=> '2024-12-12',
            'location'=> '5058 Monahan Green',
            'participants'=> 'Jorge,Joao,Rafael'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $masterToken,
        ])->postJson('api/v1/holidays', $holiday);


        $response = $this->delete(
            'api/v1/holiday/6',[],
            ['Authorization' => 'Bearer ' . $masterToken] // Headers
        );
        $response->assertStatus(200);
    }  
    
    public function test_holiday_pdf()
    {
        $setup = $this->initial();

        $masterToken = $setup['master'];
        
        $holiday = [
            'title'=> 'Final de semana',
            'description'=> 'Churrasco daora',
            'date'=> '2024-12-12',
            'location'=> '5058 Monahan Green',
            'participants'=> 'Jorge,Joao,Rafael'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $masterToken,
        ])->postJson('api/v1/holidays', $holiday);

        $response = $this->get(
            'api/v1/pdf/holiday/7',[],
            ['Authorization' => 'Bearer ' . $masterToken] // Headers
        );
        $response->assertStatus(200);
    }  
}
