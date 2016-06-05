<?php

namespace App;

use DB;
use Auth;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

trait UserRequests
{
    protected $type;
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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( $request->input('json') == true )
        {
            $rowCount = intval($request->input('rowCount', 10));
            $current = intval($request->input('current', 1));
            $sorts = $request->input('sort', false);
            $this->searchPhrase = $request->input('searchPhrase', false);
            $skip = $rowCount*($current-1);

            $requests = DB::table('requests')
                            ->where('user_id', Auth::user()->id)
                            ->join('hardwares', 'requests.hardware_id', '=', 'hardwares.id')
                            //->join('brands', 'hardwares.brand_id', '=', 'brands.id')
                            ->select(
                                'requests.*',
                                'hardwares.name as hardware_name'
                                //'brands.name as brand'
                            );

            if( !is_null($this->type) )
            {
                $requests = $requests->where('request_type', $this->type);
            }

            if( $this->searchPhrase )
            {
                $requests = $requests->Where(function($query)
                {
                    $query
                        ->where('requests.id', 'LIKE', '%'.intval($this->searchPhrase).'%')
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

        return view('manage.user-requests.index', [
            'type' => $this->type,
            'prefix' => $this->prefix,
            'name' => $this->name
        ]);
    }

    public function request(Request $request)
    {
        if( $request->input('json') == true )
        {
            $rowCount = intval($request->input('rowCount', 10));
            $current = intval($request->input('current', 1));
            $sorts = $request->input('sort', false);
            $this->searchPhrase = $request->input('searchPhrase', false);
            $skip = $rowCount*($current-1);

            $hardwares = DB::table('hardwares')
                            ->where('hardwares.type', $this->type)
                            ->whereRaw('hardwares.quantity > hardwares.quantity_use')
                            ->join('hardware_category', 'hardwares.category_id', '=', 'hardware_category.id')
                            //->join('brands', 'hardwares.brand_id', '=', 'brands.id')
                            ->select(
                                'hardwares.*',
                                'hardware_category.name as category'
                                //'brands.name as brand'
                            );
            
            if( $this->searchPhrase )
            {
                $hardwares = $hardwares->Where(function($query)
                {
                    $query->where('hardwares.name', 'LIKE', '%'.$this->searchPhrase.'%');
                });
            }

            $total = $hardwares->count();

            $hardwares = $hardwares->skip($skip)->take($rowCount);

            if( $sorts )
            {
                foreach ($sorts as $key => $value) {
                    $hardwares = $hardwares->orderBy($key, $value);
                }
            }
            else {
                $hardwares->orderBy('id', 'desc');
            }
            $json = array(
                'current'   => $current,
                'rowCount'  => $rowCount,
                'rows'  => $hardwares->get(),
                'total' => $total,
            );

            return response()->json($json);
        }

        return view('manage.user-requests.create-welcome', [
            'type' => $this->type,
            'prefix' => $this->prefix,
            'name' => $this->name,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $hardware = DB::table('hardwares')
                            ->where('hardwares.id', $request->input('id'))
                            ->join('hardware_category', 'hardwares.category_id', '=', 'hardware_category.id')
                            ->join('brands', 'hardwares.brand_id', '=', 'brands.id')
                            ->select(
                                'hardwares.*',
                                'hardware_category.name as category',
                                'brands.name as brand',
                                DB::raw('quantity - quantity_use as quantity_available')
                            )
                             ->first();

        return view('manage.user-requests.create', [
            'prefix' => $this->prefix,
            'name' => $this->name,
            'hardware' => $hardware,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $type = $request->input('type');
        $rule = [
            'datestart' => 'required', //|date',
            'quantity' => 'required|numeric|min:1'
        ];

        $message = [
            'datestart.required' => 'โปรดระบุวันที่'.$this->prefix[$type]['th'].$this->name[$type],
            //'datestart.date' => 'วันที่ไม่ถูกต้อง',
            'quantity.required' => 'โปรดป้อนจำนวน',
            'quantity.numeric' => 'จำนวนไม่ถูกต้อง',
            'quantity.min' => 'จำนวนไม่ถูกต้อง',
        ];

        if( $type == "equipment" )
        {
            $rule['datereturn'] = 'required'; //|date',
            $message['datereturn.required'] = 'โปรดระบุวันที่คืน'.$this->name[$type];
            $message['datereturn.date'] = 'วันที่ไม่ถูกต้อง';
        }

        $validator = Validator::make($request->all(), $rule, $message);

        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $datestart = Carbon::createFromFormat('d/m/Y', $request->input('datestart'))->toDateTimeString();

        $datereturn = Carbon::createFromFormat('d/m/Y', $request->input('datereturn', $request->input('datestart')))->toDateTimeString();
        
        $result = DB::table('requests')
                    ->insert([
                        'request_type' => $type,
                        'user_id' => Auth::user()->id,
                        'hardware_id' => $request->input('id'),
                        'quantity' => $request->input('quantity'),
                        'datetime_start' => $datestart,
                        'datetime_return' => $datereturn,
                        'status' => 'wait',
                        'created_at' => new Carbon,
                        'updated_at' => new Carbon
                    ]);
        
        if( $result )
        {
            DB::table('hardwares')
                    ->where('id', $request->input('id'))
                    ->update([
                        'quantity_use' => $request->input('quantity'),
                        'updated_at' => new Carbon
                    ]);
        }

        return $result ? 'true':'ไม่สามารถเพิ่มข้อมูลได้';
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
        $hardware = DB::table('hardwares')
                        ->where('id', $id)
                        ->first();

        $categorys = DB::table('hardware_category')
                            ->where('type', $this->type)
                            ->get();

        return view('admin.hardware.edit', [
            'hardware' => $hardware,
            'name' => $this->name,
            'categorys' => $categorys
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = DB::table('hardwares')
                    ->where('id', $id)
                    ->delete();

        return $result ? 'true':'false';
    }
}
