<?php

namespace App\Http\Controllers;

use App\UpdatePostModel;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class UpdateAdmin extends Controller
{
    private $pathuser = "PRiV0/user";
    private $pathwebsite = "PRiV0/website";
    public function __construct()
    {
        $this->middleware('auth');

    }
    public function adminupdateuser(Request $req)
    {
        //check for setup role
        if (Auth::check()) {
            if ($req->user()->hasRole('setup')) {

                Roles::where('user_id', Auth::user()->id)->update([
                    'role_id' => '1',
                ]);
                UpdatePostModel::where('id', auth()->user()->id)->update([
                    'zien' => 1,
                ]);
            }
        }
        //check of het leeg is
        if ($req->website == null) {
            $req->website = "#empty";
        }
        if ($req->github == null) {
            $req->github = "#empty";
        }
        if ($req->gitlab == null) {
            $req->gitlab = "#empty";
        }
        if ($req->linkedin == null) {
            $req->linkedin = "#empty";
        }

        if ($file = $req->file('profile_image')) {

            $this->validate($req, [

                'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            File::delete($this->pathuser . '/' . $req->id . '/' . $req->old_profile_image);

            $image = $req->file('profile_image');

            $image_name = time() . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_path($this->pathuser . '/' .$req->id);

            if (!File::isDirectory($destinationPath)) {

                File::makeDirectory($destinationPath, 0777, true, true);

            }

            $resize_image = Image::make($image->getRealPath());

            $resize_image->resize(640, 480, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $image_name);

            $destinationPath = public_path('/OriginalImage');

            $image->move($destinationPath, $image_name);
            File::delete('OriginalImage/' . $image_name);

            UpdatePostModel::where('id',$req->id)->update([

                'name' => $req->name,
                'background' => $req->background,
                'profile_image' => $image_name,
                'opleiding' => $req->opleiding,
                'github' => $req->github,
                'gitlab' => $req->gitlab,
                'linkedin' => $req->linkedin,
                'about' => $req->about,
                'website' => $req->website,
                'contactemail' => $req->contactemail,

            ]);
            return redirect()->route('succes');

        } else {
            UpdatePostModel::where('id', $req->id)->update([

                'name' => $req->name,
                'background' => $req->background,
                'opleiding' => $req->opleiding,
                'github' => $req->github,
                'gitlab' => $req->gitlab,
                'linkedin' => $req->linkedin,
                'about' => $req->about,
                'website' => $req->website,
                'contactemail' => $req->contactemail,

            ]);
            return redirect()->route('succes');

        }

    }

    
}
