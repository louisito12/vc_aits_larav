<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BatchColumn implements ToCollection, WithHeadingRow
{
    public $columnValues = [];

    /**
     * This method receives all rows as a collection.
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Change 'target_column' to the header name of the column you want
            // Example: if your Excel has a header "email"
            if (isset($row['claimd_id'])) {
                $this->columnValues[] = $row['claimd_id'];
            }
        }
    }
}
