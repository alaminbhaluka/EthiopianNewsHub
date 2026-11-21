<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Alert;

class ProfileController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('admin')->user();
        return view('admin.profile.index', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:190', 'unique:admins,email,' . $id],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        /** Handle image */
        $imagePath = $this->handleFileUpload($request, 'image', $request->old_image);

        /** Save updated datas */
        $admin = Admin::findOrFail($id);
        $admin->image = !empty($imagePath) ? $imagePath : $request->old_image;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->save();

        toast(__('admin.Updated Successfully'),'success')->width('400');

        return redirect()->back();

    }
    /**
     * Update the specified resource for password.
     */
    public function passwordUpdate(Request $request, string $id)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin = Admin::findOrFail($id);
        $admin->password = bcrypt($request->password);
        $admin->save();

        toast(__('admin.Updated Successfully'),'success')->width('400');

        return redirect()->back();
    }
}
