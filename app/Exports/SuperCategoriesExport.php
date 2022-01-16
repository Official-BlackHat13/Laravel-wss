<?php

namespace App\Exports;

use App\SuperCategories;
use Maatwebsite\Excel\Concerns\FromCollection;

class SuperCategoriesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SuperCategories::all();
    }
}
