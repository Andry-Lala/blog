<?php

namespace Tests\Feature;

use App\Models\Investment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InvestmentImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_own_investment_images()
    {
        // Create a user and an investment with images
        $user = User::factory()->create([
            'role' => 'client',
            'statut' => true,
        ]);

        // Create actual test files
        $idPhotoPath = 'investments/id_photos/test_id_photo.jpg';
        $transactionProofPath = 'investments/transaction_proofs/test_transaction_proof.jpg';

        // Create the actual files in storage with dummy image content
        $idPhotoContent = base64_decode('/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwA/8A8A');
        $transactionProofContent = base64_decode('/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwA/8A8A');

        Storage::disk('public')->put($idPhotoPath, $idPhotoContent);
        Storage::disk('public')->put($transactionProofPath, $transactionProofContent);

        $investment = Investment::factory()->create([
            'user_id' => $user->id,
            'id_photo' => $idPhotoPath,
            'transaction_proof' => $transactionProofPath,
        ]);

        // Test accessing ID photo
        $response = $this->actingAs($user)->get("/investments/{$investment->id}/id-photo");
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'image/jpeg');

        // Test accessing transaction proof
        $response = $this->actingAs($user)->get("/investments/{$investment->id}/transaction-proof");
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'image/jpeg');
    }

    public function test_admin_can_view_any_investment_images()
    {
        // Create a client user and an investment
        $client = User::factory()->create([
            'role' => 'client',
            'statut' => true,
        ]);

        // Create actual test files
        $idPhotoPath = 'investments/id_photos/test_admin_id_photo.jpg';
        $transactionProofPath = 'investments/transaction_proofs/test_admin_transaction_proof.jpg';

        // Create the actual files in storage with dummy image content
        $idPhotoContent = base64_decode('/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwA/8A8A');
        $transactionProofContent = base64_decode('/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwA/8A8A');

        Storage::disk('public')->put($idPhotoPath, $idPhotoContent);
        Storage::disk('public')->put($transactionProofPath, $transactionProofContent);

        $investment = Investment::factory()->create([
            'user_id' => $client->id,
            'id_photo' => $idPhotoPath,
            'transaction_proof' => $transactionProofPath,
        ]);

        // Create admin user
        $admin = User::factory()->create([
            'role' => 'administrateur',
            'statut' => true,
        ]);

        // Test admin accessing client's ID photo
        $response = $this->actingAs($admin)->get("/investments/{$investment->id}/id-photo");
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'image/jpeg');

        // Test admin accessing client's transaction proof
        $response = $this->actingAs($admin)->get("/investments/{$investment->id}/transaction-proof");
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'image/jpeg');
    }

    public function test_user_cannot_view_other_users_investment_images()
    {
        // Create two users
        $user1 = User::factory()->create([
            'role' => 'client',
            'statut' => true,
        ]);

        $user2 = User::factory()->create([
            'role' => 'client',
            'statut' => true,
        ]);

        // Create actual test files
        $idPhotoPath = 'investments/id_photos/test_user1_id_photo.jpg';
        $transactionProofPath = 'investments/transaction_proofs/test_user1_transaction_proof.jpg';

        // Create the actual files in storage with dummy image content
        $idPhotoContent = base64_decode('/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwA/8A8A');
        $transactionProofContent = base64_decode('/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwA/8A8A');

        Storage::disk('public')->put($idPhotoPath, $idPhotoContent);
        Storage::disk('public')->put($transactionProofPath, $transactionProofContent);

        // Create investment for user1
        $investment = Investment::factory()->create([
            'user_id' => $user1->id,
            'id_photo' => $idPhotoPath,
            'transaction_proof' => $transactionProofPath,
        ]);

        // Test user2 trying to access user1's ID photo
        $response = $this->actingAs($user2)->get("/investments/{$investment->id}/id-photo");
        $response->assertStatus(403);

        // Test user2 trying to access user1's transaction proof
        $response = $this->actingAs($user2)->get("/investments/{$investment->id}/transaction-proof");
        $response->assertStatus(403);
    }

    public function test_unauthenticated_user_cannot_view_investment_images()
    {
        // Create a user and an investment
        $user = User::factory()->create([
            'role' => 'client',
            'statut' => true,
        ]);

        // Create actual test files
        $idPhotoPath = 'investments/id_photos/test_unauth_id_photo.jpg';
        $transactionProofPath = 'investments/transaction_proofs/test_unauth_transaction_proof.jpg';

        // Create the actual files in storage with dummy image content
        $idPhotoContent = base64_decode('/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwA/8A8A');
        $transactionProofContent = base64_decode('/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwA/8A8A');

        Storage::disk('public')->put($idPhotoPath, $idPhotoContent);
        Storage::disk('public')->put($transactionProofPath, $transactionProofContent);

        $investment = Investment::factory()->create([
            'user_id' => $user->id,
            'id_photo' => $idPhotoPath,
            'transaction_proof' => $transactionProofPath,
        ]);

        // Test unauthenticated access to ID photo
        $response = $this->get("/investments/{$investment->id}/id-photo");
        $response->assertRedirect('/login');

        // Test unauthenticated access to transaction proof
        $response = $this->get("/investments/{$investment->id}/transaction-proof");
        $response->assertRedirect('/login');
    }

    public function test_nonexistent_image_returns_404()
    {
        // Create a user and an investment without images
        $user = User::factory()->create([
            'role' => 'client',
            'statut' => true,
        ]);

        $investment = Investment::factory()->create([
            'user_id' => $user->id,
            'id_photo' => 'investments/id_photos/test.jpg',
            'transaction_proof' => 'investments/transaction_proofs/test.jpg',
        ]);

        // Test accessing non-existent ID photo
        $response = $this->actingAs($user)->get("/investments/{$investment->id}/id-photo");
        $response->assertStatus(404);

        // Test accessing non-existent transaction proof
        $response = $this->actingAs($user)->get("/investments/{$investment->id}/transaction-proof");
        $response->assertStatus(404);
    }
}
