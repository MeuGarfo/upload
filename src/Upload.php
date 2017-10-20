<?php
namespace Basic;

class Upload
{
    /**
    * Converte o tamanho máximo do upload para bytes
    * @param  string  $sSize String com o tamanho
    * @return integer        Valor em bytes
    */
    private function convertPhpSizeToBytes(string $sSize):integer
    {
        if (is_numeric($sSize)) {
            return $sSize;
        }
        $sSuffix = substr($sSize, -1);
        $iValue = substr($sSize, 0, -1);
        switch (strtoupper($sSuffix)) {
            case 'P':
            $iValue *= 1024;
            break;
            case 'T':
            $iValue *= 1024;
            break;
            case 'G':
            $iValue *= 1024;
            break;
            case 'M':
            $iValue *= 1024;
            break;
            case 'K':
            $iValue *= 1024;
            break;
        }
        return $iValue;
    }
    /**
    * Retorna o tamanho máximo permitido para o arquivo enviado
    * @return string Tamanho do arquivo
    */
    public function maxUploadSize():string
    {
        return min(
            $this->convertPhpSizeToBytes(ini_get('post_max_size')),
            $this->convertPhpSizeToBytes(ini_get('upload_max_filesize'))
        );
    }
    /**
    * Move o arquivo enviado para o destino
    * @param  string $filename     Nome do arquivo temporário
    * @param  string $destination  Nome do arquivo de destino
    * @return bool                Retorna true ou false
    */
    public function move(string $filename,string $destination):bool
    {
        if(move_uploaded_file(string $filename , string $destination)){
            return true;
        }else{
            return false;
        }
    }
    /**
    * Enviar arquivo
    * @param  string $name Nome do campo $_FILES
    * @param  array  $exts Lista de extensões permitidas
    * @return array        Array com dados do upload
    */
    public function upload(string $name, array $exts):array
    {
        $maxSize = $this->maxUploadSize();
        $error = false;
        switch (@$_FILES[$name]['error']) {
            case 0:
            $file['size'] = @$_FILES[$name]['size'];
            if ($file['size'] < $maxSize) {
                $file['name'] = @$_FILES[$name]['name'];
                $file['ext'] = @pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);
                $file['ext'] = strtolower($file['ext']);
                $file['temp'] = @$_FILES[$name]['tmp_name'];
                if (in_array($file['ext'], $exts)) {
                    $isImage = getimagesize($_FILES[$name]['tmp_name']);
                    if ($isImage) {
                        $file['is_image'] = true;
                    } else {
                        $file['is_image'] = false;
                    }
                } else {
                    $error[] = 'invalid_extension';
                }
            } else {
                $error[] = 'invalid_size';
            }
            break;
            case 1:
            case 2:
            $error[] = 'invalid_size';
            break;
            default:
            $error[] = 'unknown_error';
            break;
        }
        if ($error) {
            $file['error'] = $error;
        }
        return $file;
    }
}
