<?php

namespace App\Lib;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class Files extends Controller{

    /** -------------------------------------------------------------------------------
     *                      Store file
     * --------------------------------------------------------------------------------
     * @param Request $request     Request post objects
     * @param STR     $inputName   Input file name used in front. (POST index)
     * @param STR     $driver      Diver name where to store the file
     * @param STR     $complement  Complement for Storage path after driver position
     *
     * @return file to client
     */
    public static function loadFile(Request $request, $inputName, $driver, $complement = ''){
        if($request->hasFile($inputName)){
            $path = $request->file($inputName)->store('/'.$complement, $driver);
            return $path;
        }else{
            return null;
        }
    }

    /** -------------------------------------------------------------------------------
     *                      Download file
     * --------------------------------------------------------------------------------
     * @param STR    $driver       Diver name where to find file
     * @param STR    $fileName     FileName (hashname with extension)
     * @param STR    $downloadName Name of the final download file
     *
     * @return file to client
     */
    public static function getFile($driver, $fileName, $downloadName = null){
        if(Storage::disk($driver)->exists($fileName)){
            if($downloadName !== null){
                return response()->download(Storage::disk($driver)->getDriver()->getAdapter()->applyPathPrefix($fileName), $downloadName);
            }
            return response()->download(Storage::disk($driver)->getDriver()->getAdapter()->applyPathPrefix($fileName));
        }else{
            abort(404);
        }
    }

    /** -------------------------------------------------------------------------------
     *                      Return File content file
     * --------------------------------------------------------------------------------
     * @param STR    $driver       Diver name where to find file
     * @param STR    $fileName     FileName (hashname with extension)
     *
     * @return STR File content to client
     */
    public static function getFileContent($driver, $fileName){

        if(Storage::disk($driver)->exists($fileName)){
            return Storage::disk($driver)->get($fileName);
        }else{
            return false;
        }
    }

    /** -------------------------------------------------------------------------------
     *                      Delete stored file
     * --------------------------------------------------------------------------------
     * @param STR    $driver       Diver name where to find file
     * @param STR    $fileName     FileName (hashname with extension)
     *
     * @return BOOL true if deleted, false otherwise
     */
    public static function removeFile($driver, $fileName){
        if(Storage::disk($driver)->exists($fileName)){
            Storage::disk($driver)->delete($fileName);
            return true;
        }else{
            return false;
        }
    }

    /** -------------------------------------------------------------------------------
     *                   Remove all files and folders
     * --------------------------------------------------------------------------------
     * @param STR    $driver       Diver name where to start
     * @param STR    $complement   Complement for Storage path after driver position. Need to be fixed, otherwise can't delete root directory
     *
     *
     * @return BOOL true if deleted, false otherwise
     */
    public static function removeFilesAndFolders($driver, $complement='/'){
        if(!Storage::disk($driver)->exists($complement)){
            return false;
        }
        return Storage::disk($driver)->deleteDirectory($complement);
    }

    public static function getFilePath($driver, $fileName){
        return Storage::disk($driver)->getDriver()->getAdapter()->applyPathPrefix($fileName);
    }

    public static function getStoragePath($driver){
        return Storage::disk($driver)->getAdapter()->getPathPrefix();
    }
}
