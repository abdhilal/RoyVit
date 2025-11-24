<?php

namespace App\Services;

use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PharmacyService
{
    public function getPharmacies(Request $request = null)
    {
        $query = Pharmacy::query()->with(['warehouse', 'area', 'representative'])->where('warehouse_id', Auth::user()->warehouse_id)->whereHas('transactions', function ($q) {
            $q->where('file_id', getDefaultFileId());
        });
        if ($request && $request->filled('search')) {
            $this->applySearch($query, $request->input('search'));
        }
        return $query->latest()->paginate(20);
    }

    public function applySearch($query, string $term)
    {
        $query->where(function ($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")

                ->orWhereHas('area', function ($a) use ($term) {
                    $a->where('name', 'LIKE', "%{$term}%");
                });

        });
    }

    public function createPharmacy(array $data): Pharmacy
    {
        return Pharmacy::create($data);
    }

    public function updatePharmacy(Pharmacy $pharmacy, array $data): Pharmacy
    {
        $pharmacy->update($data);
        return $pharmacy;
    }

    public function deletePharmacy(Pharmacy $pharmacy): void
    {
        $pharmacy->delete();
    }
}
