<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CKEditorController extends Controller
{
    public function index($path)
    {
        $url = "uploads/".$path.".html";

        if (Storage::disk('public')->exists($url)) {
            $var = Storage::get('public/'.$url);
            return view('editor', ['dane' => $var, 'path' => $path]);
        }
        else{
            Storage::disk('public')->put($url, 'Wprowadź tutaj zawartość podstrony');
            return redirect('editor/'.$path);
        }
    }
    public function create()
    {
        //
    }
    public function store(Request $request, $path)
    {
        $var = "uploads/".$path.".html";
        if($request->get('summary-ckeditor')){
            Storage::disk('public')->put($var, $request->get('summary-ckeditor'));
            return redirect('storage/'.$var);
        }
        else{
            return "plik jest pusty";
    }

    }
    public function show($name)
    {
        $url = "uploads/".$name.".html";
        if (Storage::disk('public')->exists($url)) {
            $var = Storage::get('public/'.$url);
            return redirect('storage/'.$url);
        }
        else{
            return "nie znaleziono pliku o tej nazwie";
        }
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename.'_'.time().'.'.$extension;

            //Upload File
            $request->file('upload')->storeAs('public/uploads', $filenametostore);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/uploads/'.$filenametostore);
            $msg = 'Image successfully uploaded';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            // Render HTML output
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }
    }
}
