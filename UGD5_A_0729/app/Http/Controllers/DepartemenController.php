<?php

namespace App\Http\Controllers;

/* Import Model */
use Mail;
use App\Mail\DepartemenMail;
use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    /**
     * index
     * 
     * @return void
     */

    public function index()
    {
        $departemen = Departemen::get();
        $departemen = Departemen::paginate(5);
        return view('departemen.index', compact('departemen'));
    }

    public function create(){
        return view('departemen.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'nama_departemen'   => 'required',
            'nama_manager'      => 'required',
            'jumlah_pegawai'    => 'required'
        ]);

        Departemen::create([
            'nama_departemen'   => $request->nama_departemen,
            'nama_manager'      => $request->nama_manager,
            'jumlah_pegawai'    => $request->jumlah_pegawai
        ]);

        try{
            $content = [
                'body' => $request->nama_departemen,
            ];

            Mail::to('devincondro123@gmail.com')->send(new DepartemenMail($content));
            return redirect()->route('departemen.index')->with(['success' => 'Data Berhasil disimpan, email berhasil terkirim!']);
        }catch(Exception $e){
            return redirect()->route('departemen.index')->with(['success' => 'Data Berhasil disimpan, namun email tidak berhasil terkirim!']);
        }
    }

    public function edit($id){
        $depart = Departemen::findorfail($id);
        return view('departemen.edit', compact('depart'));
    }

    public function update(Request $request, $id){
        $depart = Departemen::findorfail($id);
        $this->validate($request, [
            'nama_departemen'   => 'required',
            'nama_manager'      => 'required',
            'jumlah_pegawai'    => 'required'
        ]);

        $depart->update([
            'nama_departemen'   => $request->nama_departemen,
            'nama_manager'      => $request->nama_manager,
            'jumlah_pegawai'    => $request->jumlah_pegawai
        ]);
            return redirect()->route('departemen.index')->with(['success' => 'Data Berhasil diedit']);
    }

    public function destroy($id){
        $depart = Departemen::find($id);
        $depart->delete();
        return redirect()->route('departemen.index')->with(['success' => 'Data Berhasil dihapus!']);
    }
}
