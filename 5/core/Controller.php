<?php

abstract class Controller {
    protected $userId = null;
    protected $userRole = null;
    protected $userData = null;
    
    public function __construct() {
        if (isset($_SESSION['user_id'])) {
            $this->userId = $_SESSION['user_id'];
            $this->userRole = $_SESSION['user_role'] ?? null;
            $this->userData = $_SESSION['user_data'] ?? [];
        }
    }
    
    protected function render($view, $data = []) {
        extract($data);
        $viewPath = BASE_PATH . '/app/Views/' . $view . '.php';
        if (!file_exists($viewPath)) {
            http_response_code(404);
            die('View not found: ' . $view);
        }
        require $viewPath;
    }
    
    protected function json($data, $code = 200) {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode($data);
        exit;
    }
    
    protected function redirect($url) {
        header("Location: {$url}");
        exit;
    }
    
    protected function requireAuth() {
        if (!$this->userId) {
            $this->redirect(BASE_URL . '/public/index.php?c=Auth&m=login');
        }
    }
    
    protected function requireRole($role) {
        $this->requireAuth();
        if (!in_array($this->userRole, (array)$role)) {
            http_response_code(403);
            die('Access Denied');
        }
    }
    
    protected function get($key, $default = null) {
        return $_GET[$key] ?? $default;
    }
    
    protected function post($key, $default = null) {
        return $_POST[$key] ?? $default;
    }
    
    protected function postAll() {
        return $_POST;
    }
    
    protected function validate($data, $rules) {
        $errors = [];
        foreach ($rules as $field => $fieldRules) {
            $fieldRules = is_array($fieldRules) ? $fieldRules : [$fieldRules];
            $value = $data[$field] ?? null;
            
            foreach ($fieldRules as $rule) {
                if ($rule === 'required' && empty($value)) {
                    $errors[$field] = "{$field} không được trống";
                }
                if ($rule === 'email' && !empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = "{$field} không hợp lệ";
                }
            }
        }
        return $errors;
    }
}
