<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        $user = auth()->guard('admin')->user();
        return view('admin.profile.index', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:190', 'unique:admins,email,' . $id],
            'phone' => ['nullable', 'string', 'max:20', 'unique:admins,phone,' . $id],
            'image' => ['nullable', 'image', 'max:5120'],
        ], ['phone.unique' => 'এই মোবাইল নম্বরটি অন্য অ্যাকাউন্টে ব্যবহার করা হয়েছে।']);

        $imagePath = $this->handleFileUpload($request, 'image', $request->old_image);
        $admin = Admin::findOrFail($id);
        $admin->image = !empty($imagePath) ? $imagePath : $request->old_image;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone ? preg_replace('/\D+/', '', $request->phone) : null;
        $admin->save();

        toast(__('admin.Updated Successfully'),'success')->width('400');
        return redirect()->back();
    }

    public function passwordUpdate(Request $request, string $id)
    {
        $request->validate(['password' => ['required', 'string', 'min:8', 'confirmed']]);
        $admin = Admin::findOrFail($id);
        $admin->password = bcrypt($request->password);
        $admin->save();
        toast(__('admin.Updated Successfully'),'success')->width('400');
        return redirect()->back();
    }
}
