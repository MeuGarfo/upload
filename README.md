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
if(isset($file['error'])){
    print '<pre>';
    print_r($file['error']);
}else{
    print 'arquivo enviado com sucesso';
}
```

## mensagens de erro
```
invalid_extension
invalid_size
unknown_error
```
