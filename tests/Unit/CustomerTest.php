<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Tests\TestCase;


class CustomerTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    /** @test */
    public function it_can_fetch_a_list_of_customers()
    {
        $this->authenticate();
        Customer::factory()->count(15)->create();

        $response = $this->getJson('/api/customers');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'first_name',
                        'last_name',
                        'email',
                        'birthdate',
                    ],
                ],
                'pagination' => [
                    'current_page',
                    'total_pages',
                    'total_items',
                ],
            ]);
    }
    /** @test */
    public function it_can_create_a_new_customer()
    {
        $this->authenticate();

        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'birthdate' => '2000-01-01',
        ];

        $response = $this->postJson('/api/customers', $data);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Customer Created Successfully!',
                'data' => [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                    'birthdate' => $data['birthdate'],
                ],
            ]);

        $this->assertDatabaseHas('customers', $data);
    }
    /** @test */
    public function it_can_fetch_a_specific_customer()
    {
        $this->authenticate();
        $customer = Customer::factory()->create();

        $response = $this->getJson("/api/customers/{$customer->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Customer Fetched Successfully!',
                'data' => [
                    'id' => $customer->id,
                    'first_name' => $customer->first_name,
                    'last_name' => $customer->last_name,
                    'email' => $customer->email,
                    'birthdate' => $customer->birthdate,
                ],
            ]);
    }
    /** @test */
    public function it_can_update_a_customer()
    {
        $this->authenticate();
        $customer = Customer::factory()->create();
        $updatedData = [
            'first_name' => 'UpdatedFirstName',
            'last_name' => 'UpdatedLastName',
            'email' => 'updated@example.com',
            'birthdate' => '1995-01-01',
        ];

        $response = $this->putJson("/api/customers/{$customer->id}", $updatedData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Customer Updated Successfully!',
                'data' => [
                    'id' => $customer->id,
                    'first_name' => $updatedData['first_name'],
                    'last_name' => $updatedData['last_name'],
                    'email' => $updatedData['email'],
                    'birthdate' => $updatedData['birthdate'],
                ],
            ]);

        $this->assertDatabaseHas('customers', $updatedData);
    }
    /** @test */
    public function it_can_delete_a_customer()
    {
        $this->authenticate();
        $customer = Customer::factory()->create();

        $response = $this->deleteJson("/api/customers/{$customer->id}");
        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Customer Deleted Successfully!',
                'data' => [],
            ]);

        $this->assertSoftDeleted('customers', ['id' => $customer->id]);
    }
}
