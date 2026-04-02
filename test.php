<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::create(
        '/test', 'GET'
    )
);

$req = new Illuminate\Http\Request();
$p = App\Models\Paket::find(4);
$req->replace(['budget' => $p->minimal_budget, 'paket_id' => 4]);

$controller = new App\Http\Controllers\PesananController();
echo $controller->rekomendasiAjax($req)->getContent();
