<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index()
    {
       $users=User::select('id', 'name', 'email', 'logo', 'website')->get();
       return view('index')->with('users', $users);
    }
    public function show($id)
    {
        $user = User::find($id);
        return $user;
    }
    public function edit(Request $request,$id)
    {
        $user = User::find($id);
        if ($request->hasFile('logo')) {
            if ($user->logo) {
                $exist =  Storage::disk('public')->exists("images/{$user->logo}");
                if ($exist) {
                    Storage::disk('public')->delete("images/{$user->logo}");
                }
            }
            $imageName = Str::random() . '.' . $request->logo->getClientOriginalExtension();
            Storage::disk('public')->put('images', $request->logo, $imageName);
            $request->logo = $imageName;
        }
       $user->update($request->all());
       return redirect('/index')->with('msg', "updated successfuly");
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/index')->with('msg', "deleted successfuly");
    }
}
