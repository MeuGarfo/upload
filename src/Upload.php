<?php
namespace Basic;

class Upload
{
    /**
    * Retorna o tamanho máximo permitido para o arquivo enviado
    * @return string Tamanho do arquivo
    */
    public function maxUploadSize()
    {
        $value=ini_get('upload_max_filesize');
        if (is_numeric($value)) {
            return $value;
        } else {
            $value_length = strlen($value);
            $qty = substr($value, 0, $value_length - 1);
            $unit = strtolower(substr($value, $value_length - 1));
            switch ($unit) {
                case 'k':
                $qty *= 1024;
                break;
                case 'm':
                $qty *= 1048576;
                break;
                case 'g':
                $qty *= 1073741824;
                break;
            }
            return $qty;
        }
    }
    /**
    * Move o arquivo enviado para o destino
    * @param  string $filename     Nome do arquivo temporário
    * @param  string $destination  Nome do arquivo de destino
    * @return bool                Retorna true ou false
    */
    public function move(string $filename, string $destination)
    {
        if (move_uploaded_file($filename, $destination)) {
            return true;
        } else {
            return false;
        }
    }
    /**
    * Enviar arquivo
    * @param  string $name Nome do campo $_FILES
    * @param  array  $exts Lista de extensões permitidas
    * @return array        Array com dados do upload
    */
    public function upload(string $name, array $exts)
    {
        $maxSize = $this->maxUploadSize();
        $errors = false;
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
                    $errors[] = 'invalid_extension';
                }
            } else {
                $errors[] = 'invalid_size';
            }
            break;
            case 1:
            case 2:
            $errors[] = 'invalid_size';
            break;
            default:
            $errors[] = 'unknown_error';
            break;
        }
        if ($errors) {
            $file['errors'] = $errors;
        }
        return $file;
    }
}
