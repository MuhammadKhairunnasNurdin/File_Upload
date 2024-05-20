<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class FileUploadController extends Controller
{
    public function fileUpload(): View
    {
        return view('file-upload');
    }

    public function prosesFileUpload(Request $request)
    {
        /*if ($request->hasFile('berkas')) {
            echo 'path(): ' . $request->file('berkas')->path();
            echo '<br>';
            echo 'extension(): ' . $request->file('berkas')->extension();
            echo '<br>';
            echo 'getClientOriginalExtension(): ' . $request->file('berkas')->getClientOriginalExtension();
            echo '<br>';
            echo 'getMimetype(): ' . $request->file('berkas')->getMimetype();
            echo '<br>';
            echo 'getClientOriginalName(): ' . $request->file('berkas')->getClientOriginalName();
            echo '<br>';
            echo 'getSize(): ' . $request->file('berkas')->getSize();
            echo '<br>';
        } else {
            echo 'Tidak ada berkas yang diupload';
        }*/

        /**
         * validation for image
         */
        $request->validate([
            'berkas' => 'required|file|image|max:5000'
        ]);
        $file = $request->file('berkas');
        $namaFile = 'web-' . time() . '.' . $file->getClientOriginalName();

        /**
         * store will move file 'path/hashed_name' to Storage/App
         */
        /*$path = $file->store('uploads');*/

        /**
         * store will move file 'path/hashed_name or custom_name' without second argument, but you can customize file name with second argument and save that file to Storage/App, but remember, those file that uploaded using this function will haven't extension
         *
         * so in order to make those file had extension, you can use getClientOriginalName() function in Http/Request class
         *
         * but remember, using storeAs() with getClientOriginalName() combination had many defect, such as: if file name uploader had same name with existing storage, file will be overwritten
         */
        /*$path = $file->storeAs('public', $namaFile);*/

        $path = $file->move('image', $namaFile);
        $path = str_replace("\\","//",$path);
        echo "Variabel path berisi: $path <br>";

        $pathBaru = asset('image/' . $namaFile);

        echo "proses upload berhasil, data disimpan pada: $path";
        echo "<br>";
        echo "Tampilkan link: <a href='$pathBaru'>$pathBaru</a>";
    }
}
