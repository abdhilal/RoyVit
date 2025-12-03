<?php

namespace App\Imports;

use App\Models\Area;
use App\Models\Factory;
use App\Models\Product;
use App\Models\Pharmacy;
use Maatwebsite\Excel\Row;
use App\Models\Transaction;
use App\Models\Representative;
use App\Models\AreaRepresentative;
use App\Models\TreeProduct;
use Illuminate\Validation\Rules\In;
use Maatwebsite\Excel\Concerns\OnEachRow;

class TreeProductsImport implements OnEachRow
{
    protected $warehouseId;
    protected $year;
    protected $month;
    protected $month_year;

    public function __construct($warehouseId, $year, $month, $month_year)
    {
        $this->warehouseId = $warehouseId;
        $this->year = $year;
        $this->month = $month;
        $this->month_year = $month_year;
    }

    public function onRow(Row $row)
    {

        $r = $row->toArray();  // مصفوفة عادية مثل [0 => ..., 1 => ...]

        // تخطي الصف الأول (العناوين)
        if ($row->getIndex() === 1) {
            return;
        }

        // خريطة الأعمدة حسب ملفك
        $factoryName     = $r[0];
        $name            = $r[1];
        $quantity        = $r[2];
        $Regular_price   = $r[3];
        $Bonus1          = $r[4];
        $Bonus2          = $r[5];
        $General_price   = $r[6];
        $wholesale_price = $r[7];



        TreeProduct::create([
            'factory' => $factoryName,
            'name' => $name,
            'quantity' => abs((int) $quantity),
            'Regular_price' => (float) $Regular_price,
            'General_price' => (float) $General_price,
            'wholesale_price' => (float) $wholesale_price,
            'Bonus1' => (int) $Bonus1,
            'Bonus2' => (int) $Bonus2,
            'warehouse_id' => $this->warehouseId,
            'month' => $this->month,
            'year' => $this->year,
            'month_year' => $this->month_year,
        ]);
    }
}
