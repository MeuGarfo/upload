<?php
namespace Basic;

class Upload
{
    public function upload($name, $exts)
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

    public function convertPhpSizeToBytes($sSize)
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

    public function maxUploadSize()
    {
        return min(
            $this->convertPhpSizeToBytes(ini_get('post_max_size')),
            $this->convertPhpSizeToBytes(ini_get('upload_max_filesize'))
        );
    }
}
