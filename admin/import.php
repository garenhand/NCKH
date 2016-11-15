<?php
include '../Model/Database.php';
$success = 0;
$herror = 0;
$table='monhoc';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = array();
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $error[] = "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if ($imageFileType != "xlsx") {
        $error[] = "Sorry, PDF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $error[] = "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            require_once "../Classes/PHPExcel.php";
            $tmpfname = $target_file;
            $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
            $excelObj = $excelReader->load($tmpfname);
            $worksheet = $excelObj->getSheet(0);
            $lastRow = $worksheet->getHighestRow();
            for ($row = 2; $row <= $lastRow; $row++) {
                $ma = $worksheet->getCell('A' . $row)->getValue();
                $ten = $worksheet->getCell('B' . $row)->getValue();
                $sotinchi = $worksheet->getCell('C' . $row)->getValue();
                $objDb=new Database();
                $objDb->connect();
                $data=array(
                    'ma'=>$ma,
                    'ten'=>$ten,
                    'sotinchi'=>$sotinchi
                );
                if ($objDb->insert($table, $data)) {
                    $success++;
                } else {
                    $herror++;
                }
            }
        } else {
            $error[] = "Sorry, there was an error uploading your file.";
        }
    }
}
include '../template/_header.php';
?>

<div class="container" id="content">

    <div class="row" style="margin:10px; border: #ddd solid 1px; padding: 15px;">
        <div class="col-md-9">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã môn</th>
                        <th>Tên môn học</th>
                        <th colspan="3">Số tín chỉ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>1554258</td>
                        <td>Vật lý 1</td>
                        <td>2</td>
                        <td><div class="checkbox">
                            <label>
                                <input type="checkbox" value="">
                            </label>
                        </div></td>
                        <td><button type="button" class="btn btn-danger">Xóa</button>
                            <button type="button" class="btn btn-primary">Sửa</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-3">
            <div class="title">
                Import từ điển môn học
            </div>
            <?php
            if ($success > 0) {
                ?>
                <div class="alert alert-success">
                    Có <?php echo $success ?> môn học được import thành công
                </div>
                <?php
            }
            ?>
            <?php
            if ($herror > 0) {
                ?>
                <div class="alert alert-warning">
                    Có <?php echo $herror ?> môn học không được import
                </div>
                <?php
            }
            ?>
        </div>
        <div class="col-md-3">
            <form action="" method="POST" role="form" enctype="multipart/form-data">

                <label class="control-label"><i class="fa fa-file" aria-hidden="true"></i>  Your File</label>
                <input type="file" name="fileToUpload" id="unubo" class="filestyle" data-buttonText=" Select a File">
                <button type="submit" class="btn btn-info btn-lg" style="margin-top: 10px;">
                    <i class="fa fa-upload" aria-hidden="true"></i> Upload
                </button>

            </form>
        </div>
    </div>
</div>
<?php
include '../template/_footer.php';
