<?php

namespace App\Imports;

use App\Models\ProductCategory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CategoryImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function model(array $row) 
    { 
        foreach ($row as $key) {
            $id = ProductCategory::where('name', $row['parent_name'])->first();
        }
        return new ProductCategory([
            'name' => $row['name'],
            'parent_id' => $id->id,
        ]);
    }

    public function rules(): array 
    { 
        return [
            'name' => 'required',
            'parent_id' => 'optional'
        ];
    }
}
