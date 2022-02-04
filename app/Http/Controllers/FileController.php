<?php

namespace App\Http\Controllers;

use App\Lib\Files;
use database\Models\{fileEmployee, fileType};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){$this->middleware('auth');}

    public static function insertFileEmployee($request, $fkEmployee, $key, $file){
        $hashName = Files::loadFile($request, $key, fileType::getCodeFileTypeById($key));
        fileEmployee::insertFileEmployee($fkEmployee, $key, $file->getClientOriginalName(), $hashName);
    }

    public function downloadFile($fkFile){
        $request = new \Illuminate\Http\Request();
        $request->setMethod('POST');
        $request->request->add(['fkFile' => $fkFile]);
        $this->validate($request, ['fkFile' => 'required|int|exists:fileEmployee,id']);
        $fileInfo = fileEmployee::getFileInfoById($fkFile);
        return response()->download(Storage::disk($fileInfo->code)->getDriver()->getAdapter()->applyPathPrefix($fileInfo->hashName));
        //Files::getFile($fileInfo->code, $fileInfo->hashName);
    }

    public function deleteFile($fkFile){
        $request = new \Illuminate\Http\Request();
        $request->setMethod('POST');
        $request->request->add(['fkFile' => $fkFile]);
        $this->validate($request, ['fkFile' => 'required|int|exists:fileEmployee,id']);
        if(fileEmployee::deleteFileEmployee($fkFile)){
            return redirect()->back()->with('success', 'Fichier supprimé abvec succès !');
        }else{
            return redirect()->back()->with('error', 'Une erreur est survenue, veuillez contacter votre administrateur !');
        }
    }

    public function displayFile($fkFile){
        $request = new \Illuminate\Http\Request();
        $request->setMethod('POST');
        $request->request->add(['fkFile' => $fkFile]);
        $this->validate($request, ['fkFile' => 'required|int|exists:fileEmployee,id']);
        $fileInfo = fileEmployee::getFileInfoById($fkFile);
        return response()->file(Storage::disk($fileInfo->code)->getDriver()->getAdapter()->applyPathPrefix($fileInfo->hashName));
    }
}
