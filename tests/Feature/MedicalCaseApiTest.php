<?php

namespace Tests\Feature;

use App\Models\MedicalCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MedicalCaseApiTest extends TestCase
{
    use RefreshDatabase;

    public function createUser(string $role = 'Admin'): User 
    {
        return User::factory()->create(['role' => $role, 
        'password' => Hash::make('TestPassword123!'),]);
    }

    private function caseData(array $overrides = []): array 
    {
        return array_merge([
            'case_number' => 'API-TEST-001',
            'patient_reference' => 'PAT-TEST-001',
            'surgeon_name' => 'Dr. Demo',
            'implant_type' => 'Test Implant',
            'status' => 'Planning',
            'priority' => 'Medium',
            'surgery_date' => null,
        ], $overrides);
    }

    private function createCase(User $user, 
    array $overrides = []): MedicalCase
    {
        return MedicalCase::create(array_merge(
            $this->caseData($overrides), 
            ['created_by' => $user->id]
        ));
    }

    public function test_valid_login_returns_a_token(): void 
    {
        $user = $this->createUser();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'TestPassword123!',
        ]);

        $response->assertOk()->assertJsonPath('success', true)
        ->assertJsonStructure(['data' => ['user', 'token'],]);
    }

    public function test_invalid_login_is_rejected(): void 
    {
        $user = $this->createUser();

        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'WrongPassword!',
        ])->assertUnauthorized()
        ->assertJsonPath('success', false);
    }

    public function test_guest_cannot_access_cases(): void 
    {
        $this->getJson('/api/cases')->assertUnauthorized();
    }

    public function test_admin_can_create_a_case(): void 
    {
        $admin = $this->createUser('Admin');

        Sanctum::actingAs($admin);

        $this->postJson('/api/cases', $this->caseData())
        ->assertCreated()->assertJsonPath('success', true);

        $this->assertDatabaseHas('medical_cases', [
            'case_number' => 'API-TEST-001', 
            'created_by' => $admin->id,
        ]);
    }

    public function test_duplicate_case_number_is_rejected(): void 
    {
        $admin = $this->createUser('Admin');

        Sanctum::actingAs($admin);

        $this->createCase($admin);

        $this->postJson('/api/cases', $this->caseData())
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['case_number']);
    }

    public function test_viewer_cannot_delete_a_case(): void 
    {
        $admin = $this->createUser('Admin');
        $viewer = $this->createUser('Viewer');

        $case = $this->createCase($admin);

        Sanctum::actingAs($viewer);

        $this->deleteJson('/api/cases/' . $case->id)
        ->assertForbidden();

        $this->assertDatabaseHas('medical_cases', [
            'id' => $case->id,        
        ]);
    }
}
