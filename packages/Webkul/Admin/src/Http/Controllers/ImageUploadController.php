<?php

namespace Webkul\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ImageUploadController extends Controller
{
    public function tinyMceUpload(Request $request, $type)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,gif,png|max:2000'
        ],
            [
                'image.required' => 'Please select image file',
                'image.max' => 'Image file should be less than 2MB',
                'image.*' => 'Only jpg, gif and png files allowed',
            ]);

        $imagePath = $type . '/content-images';

        $filePath = $request->file('image')
            ->store($imagePath, 'public');

        return response()->json([
            'location' => asset('storage/' . $filePath)
        ]);
    }
}
