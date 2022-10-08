<?php
namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
class PegawaiController extends Controller
{
/**
* index
*
* @return void
*/
public function index()
{
//get posts
$pegawai = Pegawai::get();
$pegawai = Pegawai::paginate(5);
//render view with posts
return view('pegawai.index', compact('pegawai'));
}
public function create(){
    $items = Departemen::all();
    return view('pegawai.create', compact('items'));
}

public function store(Request $request){
    $this->validate($request, [
        'nomor_induk_pegawai'   => 'required',
        'nama_pegawai'      => 'required',
        'departemen'        => 'required',
        'email'             => 'required',
        'telepon'           => 'required|min:6|max:7',
        'gender'            => 'required',
        'gaji_pokok'        => 'required',
        'status'            => 'required'
    ]);

    Pegawai::create([
        'nomor_induk_pegawai'   => $request->nomor_induk_pegawai,
        'nama_pegawai'      => $request->nama_pegawai,
        'id_departemen'     => $request->departemen,
        'email'             => $request->email,
        'telepon'           => $request->telepon,
        'gender'            => $request->gender,
        'status'            => $request->status
    ]);
    
}
}
