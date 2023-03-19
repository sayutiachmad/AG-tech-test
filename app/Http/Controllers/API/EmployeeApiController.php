<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class EmployeeApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function list(Request $request)
    {

        $where = array();

        if ($request->fl_name != "") {
            $where[] = ['nama', 'like', '%' . $request->fl_name . '%'];
        }

        if ($request->fl_nip != "") {
            $where[] = ['nip', 'like', '%' . $request->fl_nip . '%'];
        }

        if ($request->fl_birth_place != "") {
            $where[] = ['tempat_lahir', 'like', '%' . $request->fl_birth_place . '%'];
        }

        if ($request->fl_birth_date != "") {
            $where[] = ['tanggal_lahir', '=', date('Y-m-d', strtotime($request->fl_birth_date))];
        }

        if ($request->fl_age != "") {
            $where[] = ['umur', '=', $request->fl_age];
        }

        if ($request->fl_adress != "") {
            $where[] = ['alamat', 'like', '%' . $request->fl_adress . '%'];
        }

        if ($request->fl_religion != 'ALL') {
            $where[] = ['agama', '=', $request->fl_religion];
        }

        if ($request->fl_gender != 'ALL') {
            $where[] = ['jenis_kelamin', '=', $request->fl_gender];
        }

        if ($request->fl_mobile != "") {
            $where[] = ['no_handphone', 'like', '%' . $request->fl_mobile . '%'];
        }

        if ($request->fl_email != "") {
            $where[] = ['email', 'like', '%' . $request->fl_email . '%'];
        }

        $data = Employee::where($where);

        return DataTables::eloquent($data)
            ->make(true);
    }

    public function show($id)
    {


        $employee = Employee::where('id', '=', $id)->first();

        return response()->json(array('result' => true, 'response' => array('type' => 0, 'data' => $employee)));
    }

    public function store(Request $request)
    {

        $validator = $this->prepareValidatorRules($request);

        // response for invalid validation
        if ($validator->fails()) {
            return response()
                ->json(
                    array(
                        'result' => false,
                        'response' => array(
                            'type' => 1,
                            'msg' => $validator->errors()
                        )
                    )
                );
        }

        $format = date('Y-m-d', strtotime($request->emp_birth_date));

        $bd = new DateTime($format);
        $now = new Datetime();
        $diff = $now->diff($bd);

        $employee = Employee::make([
            'nama'          => $request->emp_name,
            'nip'           => $request->emp_nip,
            'tempat_lahir'  => $request->emp_birth_place,
            'tanggal_lahir' => date('Y-m-d', strtotime($request->emp_birth_date)),
            'umur'          => $diff->y,
            'alamat'        => $request->emp_address,
            'agama'         => $request->emp_religion,
            'jenis_kelamin' => $request->emp_gender,
            'no_handphone'  => $request->emp_mobile,
            'email'         => $request->emp_email
        ]);

        $employee->save();

        // check storing result
        if (!$employee->exists) {
            return response()->json(array('result' => false, 'response' => array('type' => 0, 'msg' => 'Terjadi kesalahan saat menyimpan data')));
        }

        // everything good, return success response
        return response()->json(array('result' => true, 'response' => array('type' => 0, 'msg' => 'Karyawan baru behasil ditambahkan')));
    }

    public function update(Request $request, $id)
    {


        $validator = $this->prepareValidatorRules($request, $id);

        // response for invalid validation
        if ($validator->fails()) {
            return response()
                ->json(
                    array(
                        'result' => false,
                        'response' => array(
                            'type' => 1,
                            'msg' => $validator->errors()
                        )
                    )
                );
        }


        $format = date('Y-m-d', strtotime($request->emp_birth_date));

        $bd = new DateTime($format);
        $now = new Datetime();
        $diff = $now->diff($bd);

        $employee = Employee::find($id);

        $employee->nama          = $request->emp_name;
        $employee->nip           = $request->emp_nip;
        $employee->tempat_lahir  = $request->emp_birth_place;
        $employee->tanggal_lahir = date('Y-m-d', strtotime($request->emp_birth_date));
        $employee->umur          = $diff->y;
        $employee->alamat        = $request->emp_address;
        $employee->agama         = $request->emp_religion;
        $employee->jenis_kelamin = $request->emp_gender;
        $employee->no_handphone  = $request->emp_mobile;
        $employee->email         = $request->emp_email;

        $employee->save();

        // check storing result
        if (!$employee->exists) {
            return response()->json(array('result' => false, 'response' => array('type' => 0, 'msg' => 'Terjadi kesalahan saat menyimpan data')));
        }

        // everything good, return success response
        return response()->json(array('result' => true, 'response' => array('type' => 0, 'msg' => 'Data Karyawan berhasil diubah')));
    }

    public function delete(Request $request, $id)
    {

        $employee = Employee::find($id);
        $res = $employee->delete();

        // check storing result
        if (!$res) {
            return response()->json(array('result' => false, 'response' => array('type' => 0, 'msg' => 'Something wrong happen while deleting data')));
        }

        // everything good, return success response
        return response()->json(array('result' => true, 'response' => array('type' => 0, 'msg' => 'Data Karyawan berhasil dihapus')));
    }

    private function prepareValidatorRules($request, $id = '')
    {
        $attr_name = [
            'emp_name'          => 'Nama',
            'emp_nip'           => 'NIP',
            'emp_birth_place'   => 'Tempat Lahir',
            'emp_birth_date'    => 'Tanggal Lahir',
            'emp_age'           => 'Umur',
            'emp_address'       => 'Alamat',
            'emp_religion'      => 'Agama',
            'emp_gender'        => 'Jenis Kelamin',
            'emp_mobile'        => 'No. Hp',
            'emp_email'         => 'email'
        ];

        if($id != ''){
            $id = ','.$id;
        }

        // validate input from employee
        $validator = Validator::make($request->all(), [
            'emp_name'          => 'required|alpha_num:ascii',
            'emp_nip'           => 'required|numeric|unique:employees,nip'.$id,
            'emp_birth_place'   => 'required|alpha:ascii',
            'emp_birth_date'    => 'required|date|date_format:"d-m-Y"',
            'emp_address'       => 'nullable',
            'emp_religion'      => 'required',
            'emp_gender'        => 'required',
            'emp_mobile'        => 'required|numeric',
            'emp_email'         => 'required|email|unique:employees,email'.$id
        ], [], $attr_name);

        return $validator;
    }
}
