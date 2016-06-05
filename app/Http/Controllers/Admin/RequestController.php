<?php

namespace App\Http\Controllers\Admin;

use DB;
use Validator;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    protected $prefix = [
        'equipment' => [
            'th' => 'ยืม', 'en' => 'borrow'
        ],
        'material' => [
            'th' => 'เบิก', 'en' => 'requisition',
        ]
    ];
    
    protected $name = [
        'equipment' => 'ครุภัณฑ์',
        'material' => 'วัสดุ',
    ];


    public function index(Request $request)
    {
        if( $request->input('json') == true )
        {
            $filter = $request->input('filter', 'all');
            $rowCount = intval($request->input('rowCount', 10));
            $current = intval($request->input('current', 1));
            $sorts = $request->input('sort', false);
            $this->searchPhrase = $request->input('searchPhrase', false);
            $skip = $rowCount*($current-1);

            $requests = DB::table('requests')
                            ->join('hardwares', 'requests.hardware_id', '=', 'hardwares.id')
                            ->join('users', 'users.id', '=', 'requests.user_id')
                            ->select(
                                DB::raw('CONCAT_WS(\' \', users.firstname, users.lastname) as user'),
                                'users.id as user_id',
                                'requests.*',
                                'hardwares.name as hardware_name'
                            );

            if( $filter !== 'all' )
            {
                $requests = $requests->where('status', $filter);
            }

            if( $this->searchPhrase )
            {
                $requests = $requests->Where(function($query)
                {
                    $query
                        ->where('requests.id', 'LIKE', '%'.intval(str_replace('#', '', $this->searchPhrase)).'%')
                        ->orWhere('sdu_id', 'LIKE', '%'.$this->searchPhrase.'%')
                        ->orWhere('user_id', 'LIKE', '%'.$this->searchPhrase.'%')
                        ->orWhere('users.firstname', 'LIKE', '%'.$this->searchPhrase.'%')
                        ->orWhere('users.lastname', 'LIKE', '%'.$this->searchPhrase.'%')
                        ->orWhere('hardwares.name', 'LIKE', '%'.$this->searchPhrase.'%');
                });
            }

            $total = $requests->count();

            $requests = $requests->skip($skip)->take($rowCount);

            if( $sorts )
            {
                foreach ($sorts as $key => $value) {
                    $requests = $requests->orderBy($key, $value);
                }
            }
            else {
                $requests->orderBy('id', 'desc');
            }
            $json = array(
                'current'   => $current,
                'rowCount'  => $rowCount,
                'rows'  => $requests->get(),
                'total' => $total,
            );

            return response()->json($json);
        }

        return view('admin.request.index', [
            'prefix' => $this->prefix,
            'name' => $this->name
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $request = DB::table('requests')
                        ->where('requests.id', $id)
                        ->join('hardwares', 'requests.hardware_id', '=', 'hardwares.id')
                        ->join('brands', 'hardwares.brand_id', '=', 'brands.id')
                        ->select(
                            'requests.*',
                            'hardwares.name as hardware_name',
                            'hardwares.model as hardware_model',
                            'brands.name as hardware_brand'
                        )
                        ->first();

        return view('admin.request.edit', [
            'request' => $request,
            'name' => $this->name,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), ['status' => 'required',
        ],['status.required' => 'โปรดระบุสถานะ']);

        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $result = DB::table('requests')
                    ->where('id', $id)
                    ->update([
                        'status' => $request->input('status'),
                        'admin_id' => Auth::user()->id,
                    ]);

        return $result ? 'true':'false';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
