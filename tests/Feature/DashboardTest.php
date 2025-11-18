<?php

namespace Tests\Feature;

use App\Models\Investment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_dashboard_with_global_investment_data()
    {
        // Create admin user
        $admin = User::factory()->create([
            'role' => 'administrateur',
            'statut' => true,
        ]);

        // Create regular users
        $client1 = User::factory()->create([
            'role' => 'client',
            'statut' => true,
        ]);

        $client2 = User::factory()->create([
            'role' => 'client',
            'statut' => true,
        ]);

        // Create investments for clients
        Investment::factory()->create([
            'user_id' => $client1->id,
            'amount' => 100000,
            'status' => 'Validé',
            'created_at' => now()->subMonth(),
        ]);

        Investment::factory()->create([
            'user_id' => $client2->id,
            'amount' => 200000,
            'status' => 'Envoyé',
            'created_at' => now()->subMonth(),
        ]);

        // Act as admin and visit dashboard
        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertStatus(200);

        // Assert that the dashboard contains global investment data
        $response->assertViewHas('totalInvestments');
        $response->assertViewHas('totalAmount');
        $response->assertViewHas('totalClients');
        $response->assertViewHas('totalValidatedAmount');
        $response->assertViewHas('totalPendingAmount');

        // Assert that the view contains the chart data
        $response->assertViewHas('validatedData');
        $response->assertViewHas('pendingData');
        $response->assertViewHas('validatedAmountData');
        $response->assertViewHas('pendingAmountData');

        // Assert that the view contains recent investments
        $response->assertViewHas('recentInvestments');

        // Assert that the view contains recent clients
        $response->assertViewHas('recentClients');
    }

    public function test_client_can_view_dashboard_with_own_investment_data()
    {
        // Create client user
        $client = User::factory()->create([
            'role' => 'client',
            'statut' => true,
        ]);

        // Create investments for the client
        Investment::factory()->count(3)->create([
            'user_id' => $client->id,
            'amount' => 50000,
            'status' => 'Validé',
        ]);

        // Create investments for another client (should not be visible)
        $otherClient = User::factory()->create([
            'role' => 'client',
            'statut' => true,
        ]);

        Investment::factory()->count(2)->create([
            'user_id' => $otherClient->id,
            'amount' => 75000,
            'status' => 'Validé',
        ]);

        // Act as client and visit dashboard
        $response = $this->actingAs($client)->get('/dashboard');

        $response->assertStatus(200);

        // Assert that the dashboard contains user's investment data
        $response->assertViewHas('userInvestments');
        $response->assertViewHas('userTotalAmount');
        $response->assertViewHas('userRecentInvestments');
        $response->assertViewHas('userValidatedData');
        $response->assertViewHas('userPendingData');

        // Assert that the view contains global statistics (but not detailed global data)
        $response->assertViewHas('totalInvestments');
        $response->assertViewHas('totalAmount');

        // Assert that the view contains admin-specific data as null for clients
        $response->assertViewHas('recentInvestments', null);
        $response->assertViewHas('recentClients', null);
        $response->assertViewHas('validatedAmountData', null);
        $response->assertViewHas('pendingAmountData', null);
        $response->assertViewHas('totalClients', null);
        $response->assertViewHas('totalValidatedAmount', null);
        $response->assertViewHas('totalPendingAmount', null);
        $response->assertViewHas('totalProcessingAmount', null);
        $response->assertViewHas('totalRejectedAmount', null);
    }
}
