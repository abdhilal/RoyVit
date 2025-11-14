<?php

namespace App\Imports;

use App\Models\Factory;
use App\Models\Product;
use App\Models\Pharmacy;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\Area;
use App\Models\File;
use App\Models\Transaction;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FilesImport implements OnEachRow, WithHeadingRow
{
    protected $fileId;
    protected $warehouseId;



    public function __construct($fileId, $warehouseId)
    {
        $this->fileId = $fileId;
        $this->warehouseId = $warehouseId;
    }

    public function onRow(Row $row)
    {
        $r = $row->toArray();

        if(empty($r['الاسم_التجاري'])) return; // تخطي الصفوف الفارغة
        dd($r['المصنع']);


        // 1️⃣ المصنع
        $factory = Factory::firstOrCreate([
            'name' => $r['المصنع']
        ]);

        // 2️⃣ المنتج
        $product = Product::firstOrCreate([
            'factory_id' => $factory->id,
            'name'       => $r['الاسم_التجاري']
        ], [
            'warehouse_id' => $this->warehouseId // يمكنك تخصيص المستودع حسب حاجتك
        ]);



        $area = Area::firstOrCreate([
            'name' => $r['المنطقة']
        ], [
            'warehouse_id' => $this->warehouseId
        ]);

        // 4️⃣ الصيدلية
        $pharmacy = Pharmacy::firstOrCreate([
            'name'         => $r['الحساب'],
            'area_id'      => $area->id,
            'warehouse_id' => $this->warehouseId
        ]);

        // 5️⃣ المندوب
        $representative = User::firstOrCreate([
            'name' => $r['المندوب']
        ], [
            'area_id' => $area->id,
            'warehouse_id' => $this->warehouseId
        ]);

        // 6️⃣ تحديد نوع العملية
        $movement = strtolower($r['الحركة']);
        if(str_contains($movement, 'مبيع')) {
            $type = 'Wholesale Sale';
        } elseif(str_contains($movement, 'عودة')) {
            $type = 'Wholesale Return';
        } else {
            $type = 'Gift';
        }

        // 7️⃣ إنشاء المعاملة
        Transaction::create([
            'factory_id'        => $factory->id,
            'pharmacy_id'       => $pharmacy->id,
            'representative_id' => $representative->id,
            'product_id'        => $product->id,
            'warehouse_id'      => $this->warehouseId,
            'file_id'           => $this->fileId,
            'type'              => $type,
            'quantity'          => $r['عدد'],
            'value'             => abs($r['مجموع_الخارج']),
            'gift_value'        => $r['قيمة_الهدايا'],
        ]);
    }
}
