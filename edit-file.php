<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit File</title>

</head>

<body>
    <?php
    if (!isset($_GET['cid'])) {
    } else {
        $document_id = $_GET['cid'];
        include './Api/View/Document.php';
        $document = new Document();
        $documentData = $document->fetchDocument($document_id);
       // print_r($documentData);

    }
    ?>
    <div class="wrapper">
        <div class="form-container">
            <form action="./Api/hook/UploadHk.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="document_id" value="<?php echo $document_id;?>">
                <div class="form-header">
                    <h2>Upload Document</h2>
                </div>
                <div class="form-control">
                    <input type="text" name="document_title" id="document_title"
                        value="<?php echo $documentData['documentTitle']; ?>">

                </div>
                <div class="form-control">
                    <input type="text" name="document_desc" id="document_desc"
                        value="<?php echo $documentData['documentDesc']; ?>">

                </div>
               
                <div class="form-control">
                    <button type="submit" name="updateDoc">Upload Document</button>

                </div>
            </form>
        </div>
    </div>
</body>

</html>

</body>

</html>