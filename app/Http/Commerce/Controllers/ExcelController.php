<?php

namespace App\Http\Commerce\Controllers;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use App\Exports\ProductsImport;
/**
 * sample excel import export
 */
class ExcelController extends Controller
{

    //
    /**
     * @return \Illuminate\Support\Collection
     */
    public function importExportView()
    {
        return view('utility.excel');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function export()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import()
    {
        Excel::import(new ProductsImport,request()->file('file'));

        return back();
    }


}

