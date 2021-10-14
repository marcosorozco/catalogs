# catalogs
Catalog data filling process

Pasos

1 Agregar "marcosorozco/catalogs": "dev-master" a composer json

"require": {
    ....,
    ....,
    "marcosorozco/catalogs": "dev-master"
},

"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/marcosorozco/catalogs.git"
    }
],

2. Agregar en config/app.php el provider \Marcosorozco\Catalogs\Providers\CatalogServiceProvider::class

"providers" => [
  ..,
  ..,
  \Marcosorozco\Catalogs\Providers\CatalogServiceProvider::class
]

3. En linea de comando correr php artisan vendor:publish --tag=catalog

4. Correr php artisan migrate

5. Happy code!

Configuracion catalog.php

middleware: es un arreglo de los middleware bajo los cuales se ejecutaran los catalogos

Ejemplo: 

'middleware' => ['auth']

Tabla catalog

  code => codigo que se mostrara en la url
  title => titulo que se mostrara en la vista
  descripcion => descripcion corta del modulo
  class => modelo que tomara el sistema para hacer el llenado de los datos









