<?php
include './../Controller/uploadCO.php';
if (!isset($_POST['upload_document']) && !isset($_GET['fid']) && !isset($_POST['updateDoc'])) {
    exit(json_encode(['success' => false, 'message' => "Invalid Request"]));

} else if (isset($_POST['upload_document'])) {
    $title = $_POST['document_title'];
    $desc = $_POST['document_desc'];
    $file = $_FILES['document_file'];
    echo "Document Title: $title <br>";
    echo "Document Description: $desc <br>";
   // print_r($file);
    $upload = new UploadCO(null, $title, $desc, $file);
    $response = $upload->introduceDoc();
    if ($response["success"]) {
        header("Location: ./../../index.php?msg=" . $response["message"]);
    } else {
        header("Location:./../../index.php?msg=upload-success");
    }
} else if (isset($_GET['fid'])) {
    $document_id = $_GET['fid'];
    $deleteDoc = new uploadCO(
        $document_id,
        null,
        null,
        null,
    );
    $res = $deleteDoc->eliminateDoc();
    header("Location:./../../index.php?msg=" . $res['message']);
} else if (isset($_POST['updateDoc'])) {
    $document_id = $_POST['document_id'];
    $document_title = $_POST['document_title'];
    $document_desc = $_POST['document_desc'];

    $update = new uploadCO(
        $document_id,
        $document_title,
        $document_desc,
        ""
    );
    $res = $update->updateDocument();
    if ($res['success'] == false) {
        header("Location:./../../edit-file.php?msg=" . $res['message']);
    } else {
        header("Location:./../../index.php?msg=" . $res['message']);
    }
}



