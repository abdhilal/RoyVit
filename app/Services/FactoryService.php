<?php

namespace App\Services;

use App\Models\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FactoryService
{
    public function getFactories(Request $request = null)
    {
        $query = Factory::with(['products' => function ($q) {
            // جلب فقط المنتجات الموجودة في مستودع المستخدم الحالي
            $q->where('warehouse_id', Auth::user()->warehouse_id);
        }])
            ->whereHas('products', function ($q) {
                // فلترة المصانع التي لديها منتجات في المستودع الحالي
                $q->where('warehouse_id', Auth::user()->warehouse_id);
            });

        if ($request && $request->filled('search')) {
            $this->applySearch($query, $request->input('search'));
        }

        return $query->orderBy('name')->paginate(20);
    }

    protected function applySearch($query, string $search)
    {
        return $query->where('name', 'like', "%{$search}%");
    }

    public function createFactory(array $data): Factory
    {
        return Factory::create($data);
    }

    public function updateFactory(Factory $factory, array $data): bool
    {
        return $factory->update($data);
    }

    public function deleteFactory(Factory $factory): ?bool
    {
        return $factory->delete();
    }
}
