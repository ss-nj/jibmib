<?php

namespace App\Http\Core\Controllers;

use App\Exports\MailsExport;
use App\Http\Controllers\Controller;

use Maatwebsite\Excel\Facades\Excel;

class NoticeController extends Controller
{

    public function index()
    {

        return view('panel.notice.index');
    }

    public function export()
    {
        return Excel::download(new MailsExport(), 'mails.xlsx');

    }
}

