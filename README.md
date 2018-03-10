# upload
:arrow_up: Sistema básico de upload

## como usar
### composer
    composer require basic/upload

### front-end
```
<form action="upload.php" enctype="multipart/form-data" method="post">
    <input name="file" type="file">
    <button type="submit">Enviar</button>
</form>
```
### back-end (upload.php)
```
<?php
require 'vendor/autoload.php';
use Basic\Upload;
$Upload=new Upload();
$exts=[
'jpg',
'png',
'gif'
];
$file=$Upload->upload('file',$exts);
if(isset($file['errors'])){
    print '<pre>';
    print_r($file['errors']);
}else{
    print 'arquivo enviado com sucesso';
}
```

## campos retornados ($file)
```
name        nome original do arquivo (string)
ext         extensão do arquivo (string)
is_image    retorna se é imagem (bool)
size        retorna o tamanho do arquivo e bytes (int)
temp        caminho temporário do arquivo (string)
errors      mensagens de erro

```

## mensagens de erro ($file['errors'])
```
invalid_extension
invalid_size
unknown_error
```
