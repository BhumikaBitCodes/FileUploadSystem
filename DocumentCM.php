<?php
include './../Config/DatabaseConfig.php';
//Defining class for database interactions
class DocumentCM extends DatabaseConfig
{
    protected function appendDocument(
        $document_title,
        $document_desc,
        $document_file,
        $document_type,
        $document_size
    ) {

        $stashstmt = $this->integrate()->prepare('INSERT INTO `documents` ( `documentTitle`, `documentDesc`, `documentFile`, `documentType`, `documentSize`) VALUES (?, ?, ?, ?, ?);');

        if (!$stashstmt->execute([$document_title, $document_desc, $document_file, $document_type, $document_size])) {
            return [
                'status' => 'error',
                'message' => 'Failed to insert document data'
            ];
        }

        $stashstmt = null;
    }
    protected function removeDoc($document_id)
    {
        $remstmt = $this->integrate()->prepare('DELETE FROM `documents` WHERE `documentId`=?;');
        if (!$remstmt->execute([$document_id])) {
            return [
                'success' => false,
                'message' => 'deletion_failed'
            ];
        }
        return [
            'success' => true,
            'message' => "delection_success"
        ];
    }
    protected function fetchFileName($document_id)
    {
        $fetchstmt = $this->integrate()->prepare('SELECT `documentFile` FROM `documents` WHERE `documentId`=?;');
        if (!$fetchstmt->execute([$document_id])) {
            return [
                'success' => false,
                'message' => "Fetching-error"
            ];
        }
        if ($fetchstmt->rowCount() > 0) {
            $record = $fetchstmt->fetch(PDO::FETCH_ASSOC);
            return $record['documentFile'];
        } else {
            return ['success' => false, "message" => 'No_data_avaiable'];
        }

    }
    protected function modifyDocument($document_id, $document_title, $document_desc)
    {
        $upstmt = $this->integrate()->prepare('UPDATE `documents` SET `documentTitle`=?, `documentDesc`=? WHERE `documentId`=?;');
        if (!$upstmt->execute([$document_title, $document_desc, $document_id])) {
            return [
                'success' => false,
                'message' => 'server-error'
            ];
        }
        return [
            'success' => true,
            'message' => 'document_updated'
        ];

    }
}



