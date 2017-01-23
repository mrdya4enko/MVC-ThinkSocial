<?php

namespace App\Models\Groups\Tools;

class InputFilter
{
    const ALLOWED_FILE_SIZE = 5000000;
    const MIME_IMAGE_FORMATS = ['jpg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif'];
    private $file = [];
    private $reason = "";
    private $ext = null;

    /**
     * @param $string
     * @return string
     */
    public function clearStr($string)
    {
        return strip_tags(trim($string));
    }


    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param $args
     * @return bool|int
     */
    public function idPrepare($args)
    {
        if (!empty($args)) {
            $rawId = $args[0];
            $id = $this->getCookedId($rawId);
            return $id;
        } else {
            return false;
        }
    }

    /**
     * @param $rawId
     * @return int Prepared id or false if cooking has failed.
     */
    private function getCookedId($rawId)
    {
        $rawId = trim($rawId);
        $startsWithId = strpos($rawId, 'id') === 0;
        if ($startsWithId) {
            $id = (int) substr($rawId, 2, strlen($rawId) - 1);
            return $id;
        } else {
            return false;
        }
    }

    public function getFileExtension()
    {
        return $this->ext;
    }

    public function isValidPicture($photo)
    {
        $this->file = $photo;
        if ($this->fileErrorCheck() and $this->fileSizeCheck() and $this->IsPicture()) {
            return true;
        } else {
            return false;
        }
    }


    private function fileErrorCheck()
    {
        if (!isset($this->file['error']) or is_array($this->file['error'])) {
            $this->reason = "Invalid Parameters";
            return false;
        } else {
            if ($this->file['error'] != UPLOAD_ERR_OK) {
                switch ($this->file['error']) {
                    case UPLOAD_ERR_NO_FILE:
                        $this->reason = "No file sent";
                        return false;
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        $this->reason = "Exceeded file size limit.";
                        return false;
                    default:
                        $this->reason = "Unknown Error";
                        return false;
                }
            } else {
                return true;
            }
        }
    }

    private function fileSizeCheck()
    {
        if ($this->file['size'] > self::ALLOWED_FILE_SIZE) {
            return false;
        } else {
            return true;
        }
    }

    private function isPicture()
    {
        $fileInfo = new \finfo(FILEINFO_MIME_TYPE);
        $this->ext = array_search($fileInfo->file($this->file['tmp_name']), self::MIME_IMAGE_FORMATS, true);
        if (!$this->ext) {
            $this->reason = "Invalid file format";
            return false;
        } else {
            return true;
        }
    }
}
