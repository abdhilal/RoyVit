<?php

use App\Models\File;



if (!function_exists('setDefaultFile')) {

    function getDefaultFileId()
    {
        $file = File::where('is_default', 1)->where('warehouse_id', auth()->user()->warehouse_id)->firstOrFail();
        return $file->id??null;
    }
}
