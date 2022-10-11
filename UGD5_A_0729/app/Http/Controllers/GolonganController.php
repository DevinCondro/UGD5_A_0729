<?php

namespace App\Http\Controllers;

use App\Mail\DepartemenMail;
use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Exception;

class GolonganController extends Controller
{
    /**
    * index
    *
    * @return void
    */
    public function index()
    {
        //render view with posts
        return view('golongan.index', compact('golongan'));
    }

    /**
    * create
    *
    * @return void
    */
    public function create()
    {
        return view('golongan.create');
    }

    public function delete()
    {

    }

    public function edit($id) {
        $golongan = Golongan::find($id);
        return view('golongan.edit', compact('golongan'));
    }


    /**
    * store
    *
    * @param Request $request
    * @return void
    */

    public function store(Request $request)
    {
        $this->validate($request, [
            'nomor_induk_pegawai'    => 'required',
            'golongan'               => 'required',
            'gaji_pokok'             => 'required',
            'tunjangan_keluarga'     => 'required',
            'tunjangan_transport'    => 'required',
            'tunjangan_makan'        => 'required'
        ]);

        Golongan::create([
            'nomor_induk_pegawai'   => $request->nomor_induk_pegawai,
            'golongan'              => $request->golongan,
            'gaji_pokok'            => $request->gaji_pokok,
            'tunjangan_keluarga'    => $request->tunjangan_keluarga,
            'tunjangan_transport'   => $request->tunjangan_transport,
            'tunjangan_makan'       => $request->tunjangan_makan

        ]);

        try{
            $content = [
                'body'  => $request->nomor_induk_pegawai,
            ];

            Mail::to('devincondro123@gmail.com')->send(new GolonganMail($content));

            return redirect()->route('golongan.index')->with(['success' => 'Data Berhasil Disimpan, email telah terkirim!']);
        }catch(Exception $e) {
            return redirect()->route('golongan.index')->with(['success' => 'Data Berhasil Disimpan, namun gagal mengirim email!']);
        }
    }
    /**
    * update
    *
    * @param Request $request
    * @return void
    */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'nomor_induk_pegawai'   => 'required',
            'golongan'              => 'required',
            'gaji_pokok'            => 'required',
            'tunjangan_keluarga'    => 'required',
            'tunjangan_transport'   => 'required',
            'tunjangan_makan'       => 'required'
        ]);

        $golongan = Golongan::find($id);

        $golongan->nomor_induk_pegawai   = $request->nomor_induk_pegawai;
        $golongan->golongan   = $request->golongan;
        $golongan->gaji_pokok   = $request->gaji_pokok;
        $golongan->tunjangan_keluarga   = $request->tunjangan_keluarga;
        $golongan->tunjangan_transport   = $request->tunjangan_transport;
        $golongan->tunjangan_makan   = $request->tunjangan_makan;
        $golongan->update();
        return redirect()->route('golongan.index')->with(['success' => 'Data Berhasil Diedit']);
    }

    public function destroy($id) {
        $golongan = Golongan::find($id);

        $golongan->delete();

        if ($golongan) {
            return redirect()
                ->route('golongan.index')
                ->with([
                    'success' => 'Golongan Berhasil Dihapus'
                ]);
        } else {
            return redirect()
                ->route('golongan.index')
                ->with([
                    'error' => 'Golongan Tidak Berhasil Dihapus'
                ]);
        }
    }

}
