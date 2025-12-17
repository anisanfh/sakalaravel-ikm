// app/Http/Kernel.php
protected $routeMiddleware = [
// ... yang lain
'auth' => \App\Http\Middleware\Authenticate::class,
'role' => \App\Http\Middleware\CheckRole::class, // <-- Tambah ini
    ];