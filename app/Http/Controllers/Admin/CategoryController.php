<?php

namespace App\Http\Controllers\Admin;

use DB;
use Validator;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $request;
    protected $name = [
        'equipment' => 'ครุภัณฑ์',
        'material' => 'วัสดุ',
    ];


    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->type = $this->request->input('type');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( $this->request->input('json') == true )
        {
            $rowCount = intval($this->request->input('rowCount', 10));
            $current = intval($this->request->input('current', 1));
            $sorts = $this->request->input('sort', false);
            $skip = $rowCount*($current-1);

            $categorys = DB::table('hardware_category')
                            ->where('type', $this->type);

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

        return view('admin.category.index', [
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
        return view('admin.category.create', [
            'type' => $this->type,
            'name' => $this->name
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ],[
            'name.required' => 'โปรดป้อนชื่อประเภท',
        ]);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $result = DB::table('hardware_category')
                    ->insert([
                        'name' => $request->input('name'),
                        'type' => $request->input('type'),
                        'created_at' => new Carbon,
                        'updated_at' => new Carbon
                    ]);

        return $result ? 'true':'false';
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
        //
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
        $result = DB::table('hardware_category')
                    ->where('id', $id)
                    ->update([
                        'name' => $request->input('name'),
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
        $result = DB::table('hardware_category')
                    ->where('id', $id)
                    ->delete();

        return $result ? 'true':'false';
    }
}
