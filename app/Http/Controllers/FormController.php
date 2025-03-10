<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function show()
    {
        $data = Form::get();
        return view('pages.form.show', compact('data'));
    }

    public function store(Request $request)
    {
        $id = Form::withTrashed()->count() + 1;
        $tambah = new Form();
        $tambah->id_form    = $id;
        $tambah->kode_form  = $request->kode;
        $tambah->nama_form  = $request->form;
        $tambah->save();

        return redirect()->route('form')->with('success', 'Berhasil Menambahkan');
    }

    public function update(Request $request, $id)
    {
        Form::where('id_form', $id)->update([
            'nama_form' => $request->form
        ]);

        return redirect()->route('form')->with('success', 'Berhasil Memperbaharui');
    }
}
