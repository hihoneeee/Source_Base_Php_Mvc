<?php

namespace App\Helpers;

use Exception;

class HandleFileUpload
{
    // Hàm upload file
    public static function handleImageUpload(array $file, string $folderName)
    {
        try {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("Lỗi tải lên tệp: " . self::getUploadErrorMessage($file['error']));
            }

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $originalName = $file['name'];
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            if (!in_array($extension, $allowedExtensions)) {
                throw new Exception("Định dạng file không được hỗ trợ");
            }

            $baseName = pathinfo($originalName, PATHINFO_FILENAME);
            $newFileName = strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $baseName)) . rand(1000, 9999) . '.' . $extension;

            $uploadDir = __DIR__ . "/../../App/Public/Uploads/$folderName/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $targetPath = $uploadDir . $newFileName;
            if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                throw new Exception("Không thể lưu file vào thư mục");
            }

            return $newFileName;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    // Hàm xóa file
    public static function deleteFile(string $fileName, string $folderName)
    {
        try {
            $filePath = __DIR__ . "/../../App/Public/Uploads/$folderName/" . $fileName;

            if (!file_exists($filePath)) {
                throw new Exception("File không tồn tại: $fileName");
            }

            if (!unlink($filePath)) {
                throw new Exception("Không thể xóa file: $fileName");
            }

            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    private static function getUploadErrorMessage($errorCode)
    {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return 'Kích thước file quá lớn';
            case UPLOAD_ERR_PARTIAL:
                return 'File chỉ được tải lên một phần';
            case UPLOAD_ERR_NO_FILE:
                return 'Không có file nào được tải lên';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Thiếu thư mục tạm';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Không thể ghi file vào đĩa';
            case UPLOAD_ERR_EXTENSION:
                return 'Tải file bị dừng bởi extension';
            default:
                return 'Lỗi không xác định';
        }
    }
}