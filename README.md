# upload
:arrow_up: Sistema básico de upload

## como usar
```
$Upload=new Upload();
$exts=[
'jpg',
'png',
'gif'
];
$file=$Upload->upload($name,$exts);
if($file){
    print 'arquivo enviado com sucesso';
}else{
    print '<pre>';
    var_dump($file);
}
```

## mensagens de erro
```
invalid_extension
invalid_size
unknown_error
```
