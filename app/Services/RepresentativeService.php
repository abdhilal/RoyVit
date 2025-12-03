<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Representative;

class RepresentativeService
{
    public function getRepresentatives(Request $request = null)
    {
        $fileId = getDefaultFileId();
        $warehouseId = auth()->user()->warehouse_id;

        $query = Representative::query()
            ->where('type', 'sales')
            ->where('warehouse_id', $warehouseId)

            // تحميل العلاقات
            ->with(['warehouse'])
            ->withCount(['pharmacies', 'areas']);

        // إجماليات الدخل والخرج
        if (!$request || !$request->boolean('all')) {
            $query->withSum(['transactions as total_income' => function ($q) use ($fileId) {
                $q->where('file_id', $fileId);
            }], 'value_income')

                ->withSum(['transactions as total_output' => function ($q) use ($fileId) {
                    $q->where('file_id', $fileId);
                }], 'value_output');
        }
        // يظهر فقط من لديه عمليات (حسب الفايل)
        if (!$request || !$request->boolean('all')) {

            $query->whereHas('transactions', function ($q) use ($fileId) {
                $q->where('file_id', $fileId);
            });
        }

        // البحث
        if ($request && $request->filled('search')) {
            $this->applySearch($query, $request->input('search'));
        }

        if ($request && $request->boolean('all')) {
            $query->withSum([
                'transactions as total_income',
            ], 'value_income')

                ->withSum([
                    'transactions as total_output'
                ], 'value_output');
            $query->whereHas('transactions');

            $perPage = max(1, (clone $query)->count());
        }

        return $query->latest()->paginate($perPage ?? 20);
    }


    protected function applySearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
    }

    public function createRepresentative(array $data): Representative
    {
        return Representative::create($data);
    }

    public function updateRepresentative(Representative $representative, array $data): bool
    {
        return $representative->update($data);
    }

    public function deleteRepresentative(Representative $representative): ?bool
    {
        return $representative->delete();
    }
}
