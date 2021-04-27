<?php

namespace App\Exports;

use App\Http\Commerce\Models\Mail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MailsExport implements FromCollection, WithHeadings
{
    protected $supplier;

    public function __construct($supplier=null)
    {
        $this->supplier = $supplier;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Mail::select('email_address')->get();

    }


    public function headings(): array
    {
        return ['email_address'];
    }

}
