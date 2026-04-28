<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EditorUploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'uploaded' => 0,
                'error' => [
                    'message' => $validator->errors()->first('upload') ?: 'Upload gambar gagal.',
                ],
            ], 422);
        }

        $file = $request->file('upload');
        $directory = public_path('uploads/editor');

        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = 'editor_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return response()->json([
            'uploaded' => 1,
            'fileName' => $filename,
            'url' => asset('uploads/editor/' . $filename),
        ]);
    }
}
