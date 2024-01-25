<?php 

namespace App\Helpers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class Helper
{
    public static function getPermission($class, $action, $i)
    {
        $array = explode('\\',$class);
        $name = "";
        if($i==1){
            $name = strtolower($array[count($array)-1].'.'.$action);
        }else if($i==2){
            $name = strtolower($array[count($array)-2].'.'.$array[count($array)-1].'.'.$action);
        }else if($i==3){
            $name = strtolower($array[count($array)-3].'.'.$array[count($array)-2].'.'.$array[count($array)-1].'.'.$action);
        }
        
        return $name;
    }

    public static function hashFileName($file, $name='', $length=20)
    {
        $hash = Str::random(20);
        $meta = '-meta' . base64_encode($file->getClientOriginalName()) . '-';
        $extension = '.' . $file->guessExtension();

        if($name){
            return $name . $extension;
        }

        return $hash . $meta . $extension;
    }

    public static function uploadFile($oldFile='', $newFile, $name='', $path, $storage='public')
    {
        $publicUrl = Storage::url($storage.'/'.$path.'/');
           
        if($oldFile!='') {
            $currentFilename = explode("/", $oldFile);
            if(file_exists(Storage::path($storage.'/'.$path.'/'.end($currentFilename)))){
                Storage::delete($storage.'/'.$path.'/'.end($currentFilename));
            }
        }
 
        if($name==''){
            $filename = self::hashFileName($newFile);
        }else{
            $filename = self::hashFileName($newFile, $name);
        }


        $newFile->storeAs($storage.'/'.$path, $filename);

        return $publicUrl.$filename;
    }

    public static function deleteFile($file, $path, $storage='public')
    {
        if($file) {
            $currentFilename = explode("/", $file);
            if(file_exists(Storage::path($storage.'/'.$path.'/'.end($currentFilename)))){
                Storage::delete($storage.'/'.$path.'/'.end($currentFilename));
            }
        }
    }

    public static function var_export_custom($expression, $return=false) {
        $export = var_export($expression, true);
        $patterns = [
            "/array \(/" => '[',
            "/^([ ]*)\)(,?)$/m" => '$1]$2',
        ];
        $output = preg_replace(array_keys($patterns), array_values($patterns), $export);
        if ($return) {
            return $output;
        } else {
            echo $output;
        }
    }

    public static function listFile($path) 
    {
        $items = scandir($path);
        $array = [];
        
        foreach($items as $item) {
        
            if($item != "." AND $item != "..") {
                if (is_file($path . $item)) {
                    $array[] = $item;
                } else {
                    $array[$item] = self::listFile($path . $item . "/");
                    
                }
            }
        }

        return $array;
    }
}