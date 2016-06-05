<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use PDF;

class ReportController extends Controller
{
    public function show(Request $request, $id, $format = 'html')
    {

        $prefix = [
            'equipment' => [
                'th' => 'ยืม', 'en' => 'borrow'
            ],
            'material' => [
                'th' => 'เบิก', 'en' => 'requisition',
            ]
        ];

        $ids = explode(',', $id);
        $type = [
            'equipment' => 'ครุภัณฑ์',
            'material' => 'วัสดุ',
        ];

        $requests = DB::table('requests')
                        ->whereIn('requests.id', $ids)
                        ->join('users', 'requests.user_id', '=', 'users.id')
                        ->select(
                            'requests.user_id',
                            'requests.request_type',
                            'users.sdu_id',
                            'users.firstname',
                            'users.email',
                            'users.lastname'
                        )
                        ->groupBy('users.id')
                        ->get();

        $reports = array();

        foreach ($requests as $key => $value) {
            $reports[$value->user_id] = [
                'sdu_id' => $value->sdu_id,
                'firstname' => $value->firstname,
                'lastname' => $value->lastname,
                'email' => $value->email,
                'requests' => DB::table('requests')
                                    ->where('requests.user_id', $value->user_id)
                                    ->whereIn('requests.id', $ids)
                                    ->join('hardwares', 'requests.hardware_id', '=', 'hardwares.id')
                                    ->select(
                                        'requests.*',
                                        'hardwares.name as hardware_name',
                                        'hardwares.type as hardware_type'
                                    )
                                    ->get()
            ];
        }

        //$request->input('id');

        if ($format == 'pdf')
        {
            $pdf = PDF::loadHTML('');
            
            foreach($reports as $k => $v)
            {
                $pdf->loadView('pdf.report', [
                    'response' => 'pdf',
                    'reports' => [$v],
                    'type' => $type,
                    'perfix' => $prefix,
                ]);
                $pdf->WriteHTML($pdf->html);
                $pdf->AddPage();
            }
            
            return $pdf->stream('report_'.date('YmdHis').'.pdf');
        }

        return view('pdf.report', [
            'response' => 'html',
            'reports' => $reports,
            'type' => $type
        ]);
    }
}
