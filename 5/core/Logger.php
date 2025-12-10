<?php

class Logger {
    private static $db = null;
    
    public static function init() {
        self::$db = Database::getInstance();
    }
    
    public static function log($table, $recordId, $action, $oldData = null, $newData = null, $userId = null) {
        if (!self::$db) {
            self::init();
        }
        
        try {
            $userId = $userId ?: ($_SESSION['user_id'] ?? 'SYSTEM');
            $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
            
            $sql = "INSERT INTO qlbh_lichsu (BangDuLieu, MaBanGhi, HanhDong, DuLieuCu, DuLieuMoi, MaNV, IP, ThoiGian) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $params = [
                $table,
                $recordId,
                $action,
                json_encode($oldData),
                json_encode($newData),
                $userId,
                $ip,
                date('Y-m-d H:i:s')
            ];
            
            self::$db->execute($sql, $params);
        } catch (Exception $e) {
            error_log('Logger error: ' . $e->getMessage());
        }
    }
}
