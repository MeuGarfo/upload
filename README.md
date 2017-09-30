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

## campos retornados
```
name    nome original do arquivo (string)
ext     extensão do arquivo (string)
image   retorna se é imagem (bool)
size    retorna o tamanho do arquivo e bytes (int)
temp    caminho temporário do arquivo (string)

```

## mensagens de erro
```
invalid_extension
invalid_size
unknown_error
```
