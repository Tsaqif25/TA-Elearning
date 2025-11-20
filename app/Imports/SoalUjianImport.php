<?php

namespace App\Imports;

use App\Models\SoalUjian;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SoalUjianImport implements ToModel, WithHeadingRow
{
    protected $ujian_id;

    public function __construct($ujian_id)
    {
        $this->ujian_id = $ujian_id;
    }

    public function model(array $row)
    {
        return new SoalUjian([
            'ujian_id'   => $this->ujian_id,
            'pertanyaan' => $row['pertanyaan'],
            'option_1'   => $row['option_1'],
            'option_2'   => $row['option_2'],
            'option_3'   => $row['option_3'],
            'option_4'   => $row['option_4'],
            'option_5'   => $row['option_5'],
            'answer'     => (int) $row['answer'],
        ]);
    }
}
