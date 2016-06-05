<?php

namespace App;

use DB;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

trait Hardware
{
    protected $type;
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

            $categorys = DB::table('hardwares')
                            ->where('hardwares.type', $this->type)
                            ->join('hardware_category', 'hardwares.category_id', '=', 'hardware_category.id')
                            //->join('brands', 'hardwares.brand_id', '=', 'brands.id')
                            ->select(
                                'hardwares.*',
                                'hardware_category.name as category'
                                //'brands.name as brand'
                            );
            
            if( $this->searchPhrase )
            {
                $categorys = $categorys->Where(function($query)
                {
                    $query->where('hardwares.name', 'LIKE', '%'.$this->searchPhrase.'%');
                });
            }

            $total = $categorys->count();

            $categorys = $categorys->skip($skip)->take($rowCount);

            if( $sorts )
            {
                foreach ($sorts as $key => $value) {
                    $categorys = $categorys->orderBy($key, $value);
                }
            }
            else {
                $categorys->orderBy('id', 'desc');
            }
            $json = array(
                'current'   => $current,
                'rowCount'  => $rowCount,
                'rows'  => $categorys->get(),
                'total' => $total,
            );

            return response()->json($json);
        }

        return view('admin.hardware.index', [
            'type' => $this->type,
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
        $categorys = DB::table('hardware_category')
                            ->where('type', $this->type)
                            ->get();

        $brands = DB::table('brands')->get();

        return view('admin.hardware.create', [
            'type' => $this->type,
            'name' => $this->name,
            'categorys' => $categorys,
            'brands' => $brands,
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
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $result = DB::table('hardwares')
                    ->insert([
                        'name' => $request->input('name'),
                        'hardware_id' => $request->input('hardware_id'),
                        //'brand_id' => $request->input('brand'),
                        'brand' => $request->input('brand'),
                        'model' => $request->input('model'),
                        'responsible' => $request->input('responsible'),
                        'place_id' => $request->input('place'),
                        'category_id' => $request->input('category'),
                        'quantity' => $request->input('quantity'),
                        'type' => $request->input('type'),
                        'status' => $request->input('status'),
                        'note' => $request->input('note'),
                        'get_at' => Carbon::createFromFormat('d/m/Y', $request->input('get_at'))->toDateTimeString(),
                        'created_at' => new Carbon,
                        'updated_at' => new Carbon
                    ]);

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
        $brands = DB::table('brands')->get();

        return view('admin.hardware.edit', [
            'hardware' => $hardware,
            'name' => $this->name,
            'categorys' => $categorys,
            'brands' => $brands,

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
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $result = DB::table('hardwares')
                    ->where('id', $id)
                    ->update([
                        'name' => $request->input('name'),
                        'hardware_id' => $request->input('hardware_id'),
                        'brand' => $request->input('brand'),
                        //'brand_id' => $request->input('brand'),
                        'model' => $request->input('model'),
                        'responsible' => $request->input('responsible'),
                        'place_id' => $request->input('place'),
                        'category_id' => $request->input('category'),
                        'quantity' => $request->input('quantity'),
                        'note' => $request->input('note'),
                        'status' => $request->input('status'),
                        'get_at' => Carbon::createFromFormat('d/m/Y', $request->input('get_at'))->toDateTimeString(),
                        'updated_at' => new Carbon
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
        $result = DB::table('hardwares')
                    ->where('id', $id)
                    ->delete();

        return $result ? 'true':'false';
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required',
            //'brand' => 'required',
            //'model' => 'required',
            'place' => 'required',
            'category' => 'required',
            'quantity' => 'required|numeric|min:0',
            'get_at' => 'required',
        ],[
            'name.required' => 'โปรดป้อนชื่อประเภท',
            //'brand.required' => 'โปรดเลือกยี่ห้อ',
            //'model.required' => 'โปรดป้อนรุ่น',
            'place.required' => 'โปรดเลือกสถานที่เก็บ',
            'category.required' => 'โปรดเลือกประเภท',
            'quantity.required' => 'โปรดป้อนจำนวน',
            'quantity.numeric' => 'จำนวนไม่ถูกต้อง',
            'quantity.min' => 'จำนวนไม่ถูกต้อง',
            'get_at.required' => 'โปรดป้อนวันรับเข้าระบบเมื่อ',
        ]);
    }
}
