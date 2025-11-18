<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ClientManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an admin user
        $this->admin = User::factory()->create([
            'role' => 'administrateur',
            'statut' => true,
        ]);
    }

    public function test_admin_can_view_clients_list()
    {
        Client::factory()->count(5)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('clients.index'));

        $response->assertStatus(200);
        $response->assertViewIs('clients.index');
        $response->assertViewHas('clients');
    }

    public function test_admin_can_create_client()
    {
        $clientData = [
            'nom' => 'Doe',
            'prenom' => 'John',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'telephone' => '1234567890',
            'adresse' => '123 Main St',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('clients.store'), $clientData);

        $client = Client::where('email', 'john@example.com')->first();
        $response->assertRedirect(route('clients.show', $client));
        $this->assertDatabaseHas('users', [
            'nom' => 'Doe',
            'prenom' => 'John',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'role' => 'client',
            'statut' => false,
        ]);
    }

    public function test_admin_can_verify_client()
    {
        $client = Client::factory()->create(['statut' => false]);

        $response = $this->actingAs($this->admin)
            ->patch(route('clients.verify', $client));

        $response->assertRedirect(route('clients.show', $client));
        $this->assertDatabaseHas('users', [
            'id' => $client->id,
            'statut' => true,
            'valide_par' => $this->admin->id,
        ]);
    }

    public function test_admin_can_unverify_client()
    {
        $client = Client::factory()->create([
            'statut' => true,
            'valide_par' => $this->admin->id,
            'date_validation' => now(),
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('clients.unverify', $client));

        $response->assertRedirect(route('clients.show', $client));
        $this->assertDatabaseHas('users', [
            'id' => $client->id,
            'statut' => false,
            'valide_par' => null,
        ]);
    }

    public function test_admin_can_update_client()
    {
        $client = Client::factory()->create();

        $updateData = [
            'nom' => 'Smith',
            'prenom' => 'Jane',
            'username' => 'janesmith',
            'email' => 'jane@example.com',
        ];

        $response = $this->actingAs($this->admin)
            ->patch(route('clients.update', $client), $updateData);

        $response->assertRedirect(route('clients.show', $client));
        $this->assertDatabaseHas('users', [
            'id' => $client->id,
            'nom' => 'Smith',
            'prenom' => 'Jane',
            'username' => 'janesmith',
            'email' => 'jane@example.com',
        ]);
    }

    public function test_admin_can_delete_client()
    {
        $client = Client::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete(route('clients.destroy', $client));

        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseMissing('users', ['id' => $client->id]);
    }

    public function test_client_cannot_access_client_management()
    {
        $client = Client::factory()->create(['statut' => true]);

        $response = $this->actingAs($client)
            ->get(route('clients.index'));

        $response->assertStatus(403);
    }

    public function test_client_can_view_own_profile()
    {
        $client = Client::factory()->create(['statut' => true]);

        $response = $this->actingAs($client)
            ->get(route('clients.show', $client));

        $response->assertStatus(200);
        $response->assertViewIs('clients.show');
    }

    public function test_client_cannot_view_other_client_profile()
    {
        $client1 = Client::factory()->create(['statut' => true]);
        $client2 = Client::factory()->create(['statut' => true]);

        $response = $this->actingAs($client1)
            ->get(route('clients.show', $client2));

        $response->assertStatus(403);
    }

    public function test_unverified_client_cannot_login()
    {
        $client = Client::factory()->create([
            'statut' => false,
        ]);

        $response = $this->post(route('login'), [
            'username' => $client->username,
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    public function test_verified_client_can_login()
    {
        $client = Client::factory()->make([
            'statut' => true,
            'password' => Hash::make('password'),
        ]);
        $client->save();

        $response = $this->post(route('login'), [
            'username' => $client->username,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($client);
    }

    public function test_registration_creates_unverified_client()
    {
        $registrationData = [
            'nom' => 'Doe',
            'prenom' => 'John',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('register'), $registrationData);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', [
            'nom' => 'Doe',
            'prenom' => 'John',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'role' => 'client',
            'statut' => false,
        ]);
    }

    public function test_client_search_functionality()
    {
        Client::factory()->create(['nom' => 'Smith', 'prenom' => 'John']);
        Client::factory()->create(['nom' => 'Doe', 'prenom' => 'Jane']);

        $response = $this->actingAs($this->admin)
            ->get(route('clients.index', ['search' => 'Smith']));

        $response->assertStatus(200);
        $response->assertViewHas('clients');
        $clients = $response->viewData('clients');
        $this->assertEquals(1, $clients->count());
    }

    public function test_client_filter_by_status()
    {
        Client::factory()->create(['statut' => true]);
        Client::factory()->create(['statut' => false]);

        $response = $this->actingAs($this->admin)
            ->get(route('clients.index', ['statut' => 'verified']));

        $response->assertStatus(200);
        $response->assertViewHas('clients');
        $clients = $response->viewData('clients');
        $this->assertEquals(1, $clients->count());
    }
}
