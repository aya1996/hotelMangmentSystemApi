<?php

namespace Tests\Feature;

use App\Models\Facility;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class FacilityTest extends TestCase
{
    
    public function test_user_can_store_facility()
    {
        $user = User::factory()->create();
         $response = $this->actingAs($user)->post('/api/facilities', [
            'name' => 'facility',
            'details' => 'details',   
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => trans('response.facility_created_successfully')]);
    }
    public function test_user_can_update_facility()
    {

        $user = User::factory()->create();
        $facility = Facility::factory()->create();
        $response = $this->actingAs($user)->put('/api/facilities/'.$facility->id, [
           'name' => 'facility',
           'details' => 'details',   
       ]);
       $response->assertStatus(Response::HTTP_OK);
       $response->assertJson(['message' => trans('response.facility_updated_successfully')]);

    }
    public function test_user_can_delete_facility()
    {
        DB::beginTransaction();
        $user = User::factory()->create();
        $facility = Facility::factory()->create();
        $response = $this->actingAs($user)->delete('/api/facilities/'.$facility->id);
       $response->assertStatus(Response::HTTP_OK);
       $response->assertJson(['message' => trans('response.facility_deleted_successfully')]);

    }
    public function test_user_can_show_facility()
    {
        DB::beginTransaction();
        $user = User::factory()->create();
        $facility = Facility::factory()->create();
        $response = $this->actingAs($user)->get('/api/facilities/'.$facility->id);
       $response->assertStatus(Response::HTTP_OK);
    

    }
    public function test_user_can_list_all_facility()
    {
        DB::beginTransaction();
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get('/api/facilities/');
       $response->assertStatus(Response::HTTP_OK);
    

    }










}
