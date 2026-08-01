<?php
class App {
    // Controller dan Method Default jika user hanya mengakses domain.com
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseURL();

        // 1. Setup Controller
        // Jika URL[0] ada, contoh: 'item', kita cari file ItemController.php
        if (isset($url[0])) {
            $controllerName = ucfirst($url[0]) . 'Controller';
            
            if (file_exists('../app/controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
                unset($url[0]);
            }
        }

        require_once '../app/controllers/' . $this->controller . '.php';
        // Instansiasi Controller terpilih
        $this->controller = new $this->controller;

        // 2. Setup Method
        // Jika URL[1] ada, contoh: 'detail', kita cek apakah method detail() ada di ItemController
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // 3. Setup Parameter
        // Jika masih ada sisa URL (misal: id barang, slug, dll)
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        // 4. Jalankan Controller, Method, dan kirimkan Parameter
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL() {
        if (isset($_GET['url'])) {
            // Hapus slash di akhir URL
            $url = rtrim($_GET['url'], '/');
            // Sanitasi karakter aneh (Keamanan)
            $url = filter_var($url, FILTER_SANITIZE_URL);
            // Pecah string menjadi array berdasarkan slash '/'
            $url = explode('/', $url);
            return $url;
        }
        return []; // Jika tidak ada URL, kembalikan array kosong (menggunakan default)
    }
}
?>