<?php
namespace Basic;

class Upload{
    function upload($name,$exts){
        $maxSize=$this->max_upload_size();
        $error=false;
        switch(@$_FILES[$name]["error"]){
            case 0:
            //0. upload bem sucedido
            $file['size']=@$_FILES[$name]['size'];
            if($file['size']<$maxSize){
                $file['name']=@$_FILES[$name]['name'];
                $file['ext']=@pathinfo($_FILES[$name]['name'],PATHINFO_EXTENSION);
                $file['ext']=strtolower($file['ext']);
                $file['temp']=@$_FILES[$name]['tmp_name'];
                if (in_array($file['ext'], $exts)) {
                    $isImage = getimagesize($_FILES[$name]["tmp_name"]);
                    if($isImage){
                        $file['is_image']=true;
                    }else{
                        $file['is_image']=false;
                    }
                }else{
                    $error[]='invalid_extension';
                }
            }else{
                $error[]='invalid_size';
            }
            break;
            case 1:
            case 2:
            //1. Envie um arquivo com no máximo upload_max_filesize bytes
            //2. Envie um arquivo com no máximo MAX_FILE_SIZE bytes
            $error[]='invalid_size';
            break;
            default:
            //Tente novamente
            $error[]='unknown_error';
            break;
        }
        if($error){
            $file['error']=$error;
        }
        return $file;
    }
    function convert_php_size_to_bytes($sSize)
    {
        if ( is_numeric( $sSize) ) {
            return $sSize;
        }
        $sSuffix = substr($sSize, -1);
        $iValue = substr($sSize, 0, -1);
        switch(strtoupper($sSuffix)){
            case 'P':
            $iValue *= 1024;
            case 'T':
            $iValue *= 1024;
            case 'G':
            $iValue *= 1024;
            case 'M':
            $iValue *= 1024;
            case 'K':
            $iValue *= 1024;
            break;
        }
        return $iValue;
    }
    function max_upload_size()
    {
        return min($this->convert_php_size_to_bytes(ini_get('post_max_size')), $this->convert_php_size_to_bytes(ini_get('upload_max_filesize')));
    }
}
