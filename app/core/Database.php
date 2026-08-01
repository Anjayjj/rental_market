<?php
class Database {
    public $dbh;
    private $stmt;

    public function __construct() {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        try {
            $this->dbh = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch(PDOException $e) {
            // Tampilkan error dengan jelas
            echo '<div style="padding:20px;background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;border-radius:4px;margin:20px;font-family:sans-serif;">';
            echo '<h2 style="margin-top:0;">Database Connection Error</h2>';
            echo '<p><strong>Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
            echo '<p><strong>Host:</strong> ' . htmlspecialchars(DB_HOST) . '</p>';
            echo '<p><strong>Database:</strong> ' . htmlspecialchars(DB_NAME) . '</p>';
            echo '<p><strong>User:</strong> ' . htmlspecialchars(DB_USER) . '</p>';
            echo '<p>Periksa kembali kredensial database di <code>app/config/config.php</code></p>';
            echo '</div>';
            exit;
        }
    }

    public function query($query) {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value): $type = PDO::PARAM_INT; break;
                case is_bool($value): $type = PDO::PARAM_BOOL; break;
                case is_null($value): $type = PDO::PARAM_NULL; break;
                default: $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute() {
        return $this->stmt->execute();
    }

    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
