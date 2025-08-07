<?php
include './../Model/DocumentCM.php';
class uploadCO extends DocumentCM
{
    //defining properties
    private $documentId;
    private $documentTitle;
    private $documentDesc;
    private $documentFile;
    private $documentName;
    private $documentType;
    private $documentError;
    private $documentSize;
    private $documentTmpName;
    private $destinationDir;
    // defining constructor
    public function __construct($documentId, $documentTitle, $documentDesc, $documentFile)
    {
        $this->documentId = $documentId;
        $this->documentTitle = $documentTitle;
        $this->documentDesc = $documentDesc;
        $this->documentFile = $documentFile;
        $this->documentName = $this->documentFile['name'] ?? "";
        $this->documentType = $this->documentFile['type'] ?? "";
        $this->documentError = $this->documentFile['error'] ?? "";
        $this->documentSize = $this->documentFile['size'] ?? "";
        $this->documentTmpName = $this->documentFile['tmp_name'] ?? "";
        $this->destinationDir = "./../../uploads/" . $this->documentName;
    }
    public function introduceDoc()
    {
        if ($this->isEmptyInputs() == true) {
            header("Location:./../../index.php?msg=empty-fields");
            exit();
        }
        if ($this->isUploadOK() == false) {
            header("Location:./../../index.php?msg=upload-error");
            exit();
        }
        if ($this->isTypeValid() == false) {
            header("Location:./../../index.php?msg=invalid-file-type");
            exit();
        }
        if ($this->isSizeValid() == false) {
            header("Location:./../../index.php?msg=file-too-large");
            exit();
        }
        if ($this->isFileExits() == true) {
            header("Location:./../../index.php?msg=file-exits");
            exit();

        }
        if ($this->isFileMoved() == false) {
            header("Location:./../../index.php?msg=upload-success");
            exit();
        }
        //add this line
        return $this->appendDocument(
            $this->documentTitle,
            $this->documentDesc,
            $this->documentName,
            $this->documentType,
            $this->documentSize,
        );
    }
    public function eliminateDoc()
    {
        $documentFile = $this->fetchFileName($this->documentId);
        if ($this->isFileUnlinked($documentFile) == false) {
            $response = [
                'success' => false,
                'message' => 'failed-to-linked'
            ];
        }
        $response = $this->removeDoc($this->documentId);
        return $response;
    }
    public function updateDocument()
    {
        if ($this->isEmpty() == true) {
            header("Location:./../../edit-file.php?cid=$this->documentId&msg=empty-fields");
            exit();
        }
        $response = $this->modifyDocument($this->documentId, $this->documentTitle, $this->documentDesc);
        return $response;

    }
    private function isFileUnlinked($documentFile)
    {
        if (unlink("./../../Uploads/" . $documentFile)) {
            return true;
        } else {
            return false;
        }
    }
    private function isEmptyInputs()
    {
        if (empty($this->documentTitle) || empty($this->documentDesc) || empty($this->documentFile)) {
            return true;
        } else {
            return false;
        }
    }
      private function isEmpty()
    {
        if (empty($this->documentTitle) || empty($this->documentDesc)) {
            return true;
        } else {
            return false;
        }
    }
    private function isUploadOK()
    {
        if ($this->documentError > 0) {
            return false;
        } else {
            return true;

        }
    }
    private function isTypeValid()
    {
        if ($this->documentType != "application/pdf" && $this->documentType != "application/vnd.openxmlformats-officedocument.wordprocessingml.document" && $this->documentType != "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" && $this->documentType != "application/vnd.ms-excel") {
            return false;
        } else {
            return true;
        }
    }
    private function isSizeValid()
    {
        if ($this->documentSize > 10000000) {
            return false;
        } else {
            return true;
        }
    }
    private function isFileExits()
    {

        if (file_exists($this->destinationDir)) {
            return true;
        } else {
            return false;
        }
    }
    private function isFileMoved()
    {
        if (move_uploaded_file($this->documentTmpName, $this->destinationDir)) {
            return true;
        } else {
            return false;
        }
    }
}