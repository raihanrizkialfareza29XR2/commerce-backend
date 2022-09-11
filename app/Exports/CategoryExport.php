<?php

namespace App\Exports;

use App\Models\ProductCategory;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CategoryExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    
    public function query()
    {
        return ProductCategory::query();
    }

    public function map($category): array
    { 
        return [
            $category->id,
            $category->name,
            $category->parent_id != null ? $category->parname->name : 'Parent Category'
        ];
    }

    public function headings(): array 
    { 
        return [
            'ID',
            'NAME CATEGORY',
            'PARENT CATEGORY NAME'
        ];
    }
}
