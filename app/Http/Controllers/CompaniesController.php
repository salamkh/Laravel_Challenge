<?php

namespace App\Http\Controllers;
use App\Models\Companies;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function index()
    {
       $coms=Companies::select('id', 'name', 'email','address', 'logo', 'website')->Paginate(10);
       return view('index')->with('coms', $coms);
    }
    public function show($id)
    {
        $com = Companies::find($id);
        return $com;
    }
    public function create(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            //'logo' => 'dimensions:min_width=100,min_height=100',
            'website' => ['required', 'string'],
        ]);
        if($request->hasFile('logo'))
        {
            $imageName = Str::random() . '.' . $request->logo->getClientOriginalExtension();
            Storage::disk('public/')->put('images/', $request->logo, $imageName);
            $request->logo = $imageName;
        }

        $com = Companies::create([
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'logo' => $request->logo,
            'website' => $request->website,
        ]);
       
        return redirect('/index')->with('msg', "created successfuly"); 
    }
    public function edit(Request $request,$id)
    {
        $com = Companies::find($id);
        if ($request->hasFile('logo')) {
            if ($com->logo) {
                $exist =  Storage::disk('public')->exists("images/{$com->logo}");
                if ($exist) {
                    Storage::disk('public')->delete("images/{$com->logo}");
                }
            }
            $imageName = Str::random() . '.' . $request->logo->getClientOriginalExtension();
            Storage::disk('public')->put('images', $request->logo, $imageName);
            $request->logo = $imageName;
        }
       $com->update($request->all());
       return redirect('/index')->with('msg', "updated successfuly");
    }

    public function destroy($id)
    {
        $com = Companies::find($id);
        $com->delete();
        return redirect('/index')->with('msg', "deleted successfuly");
    }
    public function find($id)
    {
        $com = Companies::find($id);
        return view('/edit')->with('com', $com);
    }

}
