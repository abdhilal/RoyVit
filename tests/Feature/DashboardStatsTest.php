<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\Area;
use App\Models\Pharmacy;
use App\Models\Representative;
use App\Models\Product;
use App\Models\Factory;
use App\Models\Transaction;
use App\Models\File;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardStatsTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_summary_and_filters()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        $warehouse = Warehouse::create(['name' => 'W1']);
        $area = Area::create(['name' => 'A1', 'warehouse_id' => $warehouse->id]);
        $rep = Representative::create(['name' => 'R1', 'type' => 'sales', 'warehouse_id' => $warehouse->id]);
        $pharmacy = Pharmacy::create(['name' => 'P1', 'area_id' => $area->id, 'warehouse_id' => $warehouse->id]);
        $factory = Factory::create(['name' => 'F']);
        $product = Product::create(['name' => 'Prod', 'factory_id' => $factory->id, 'warehouse_id' => $warehouse->id]);
        $file = File::create(['code' => 'F1', 'path' => 'x', 'month' => 1, 'year' => 2024, 'is_default' => true]);

        Transaction::create([
            'type' => 'Wholesale Sale',
            'pharmacy_id' => $pharmacy->id,
            'quantity_product' => 5,
            'product_id' => $product->id,
            'quantity_gift' => 1,
            'value_income' => 100,
            'value_output' => 20,
            'representative_id' => $rep->id,
            'area_id' => $area->id,
            'value_gift' => 5,
            'warehouse_id' => $warehouse->id,
            'file_id' => $file->id,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewHas('summary');
        $response->assertViewHas('files');

        $response = $this->get('/?type=Wholesale%20Sale');
        $response->assertStatus(200);
        $response->assertViewHas('active_type', 'Wholesale Sale');

        $response = $this->get('/?file_id=' . $file->id);
        $response->assertStatus(200);
        $response->assertViewHas('active_file_id', $file->id);
    }
}
