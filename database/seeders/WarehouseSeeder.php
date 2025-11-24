<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Currency;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use App\Models\FinancialAccount;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ------------------ إنشاء الصلاحيات ------------------

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view-warehouse',
            'create-warehouse',
            'edit-warehouse',
            'delete-warehouse',
            'show-warehouse',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'group_name' => 'Warehouse']);
        }


        // ------------------ إضافة المستودعات ------------------










        // ------------------ إضافة مناطق ------------------
    }
}
