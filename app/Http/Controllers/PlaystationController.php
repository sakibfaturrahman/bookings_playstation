<?php

namespace App\Http\Controllers;

use App\Models\Playstation;
use Illuminate\Http\Request;

class PlaystationController extends Controller
{
    //cretae function index with passing data 
    public function index()
    {
        $playstation = Playstation::paginate(10);
        return view('admin.playstation.index', compact('playstation'));
    }


   
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:playstation,name',
            'harga_sewa' => 'required|integer|min:10000',
            'deskripsi' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imageName = 'img-' . time() . '.' . $request->gambar->extension();
        $request->gambar->storeAs('public/images', $imageName);

        
        Playstation::create([
            'name' => $request->name,
            'harga_sewa' => $request->harga_sewa,
            'deskripsi' => $request->deskripsi,
            'gambar' => $imageName,
        ]);

        return redirect()->back();
    }

    //create function update data with validation and link storage image
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'harga_sewa' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $playstation = Playstation::find($id);
        $playstation->name = $request->name;
        $playstation->harga_sewa = $request->harga_sewa;
        $playstation->deskripsi = $request->deskripsi;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage'), $name);
            $playstation->gambar = $name;
        }
        $playstation->save();
        return redirect()->route('playstations.index')->with('success', 'Playstation updated successfully.');
    }

    //create function destroy data with validation clean code
    public function destroy($id)
    {
        $playstation = Playstation::find($id);
        $playstation->delete();
        return redirect()->route('playstations.index')->with('success', 'Playstation deleted successfully.');
    }

    public function list()
{
    return response()->json(Playstation::select('id', 'name', 'harga_sewa')->get());
}

}
