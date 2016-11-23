<?php
include_once '../template/_header.php';
if (!isset($_SESSION['id'])) {
    header('location:'.siteurl.'login.php');
}else {
    if ($_SESSION['type']!=1) {
        header('location:'.siteurl.'template/permission.php');
    }
}
include '../Model/Database.php';
$entry_per_page = 10;
$objDb = new Database();
$objDb->connect();
$success = 0;
$herror = 0;
$table = 'monhoc';
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
    if ($imageFileType != "xlsx") {
        $error[] = "Sorry, PDF files are allowed.";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        $error[] = "Sorry, your file was not uploaded.";
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
                $objDb = new Database();
                $objDb->connect();
                $data = array(
                    'ma' => $ma,
                    'ten' => $ten,
                    'sotinchi' => $sotinchi
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

?>
<script>

    $(document).ready(function () {

    function getMonHoc(p = 0) {
    $.ajax({
            url: "server.php", // gửi ajax đến file result.php
            type: "POST", // chọn phương thức gửi là post
            dateType: "text", // dữ liệu trả về dạng text
            data: {// Danh sách các thuộc tính sẽ gửi đi
            action: 'get',
                    key: $("#table_search").val() == undefined ? '%' : $("#table_search").val(),
                    page: p
            },
            success: function (result) {
            $('#result').html(result);
            }
    });
    }

    getMonHoc();
    })
            function saveMonHoc() {
            $.ajax({
            url: "server.php", // gửi ajax đến file result.php
                    type: "POST", // chọn phương thức gửi là post
                    dateType: "text", // dữ liệu trả về dạng text
                    data: {// Danh sách các thuộc tính sẽ gửi đi
                    action: 'add',
                            ma: $('#ma').val(),
                            ten: $('#ten').val(),
                            sotinchi: $('#sotinchi').val()
                    },
                    success: function (result) {
                    $('#add').modal('hide');
                    $('#kq').html(result);
                    $('#success').modal('show');
                    setTimeout(function () {
                    $("#success").modal('hide');
                    }, 2000);
                    getMonHoc();
                    //alert(result);
                    }
            });
            return false;

            }
    function getMonHoc(p = 0) {
        $('.modal-backdrop').hide();
    $.ajax({
    url: "server.php", // gửi ajax đến file result.php
            type: "POST", // chọn phương thức gửi là post
            dateType: "text", // dữ liệu trả về dạng text
            data: {// Danh sách các thuộc tính sẽ gửi đi
            action: 'get',
                    key: $("#table_search").val() === undefined ? '%' : $("#table_search").val(),
                    page: p
            },
            success: function (result) {
            $('#result').html(result);
            }
    });
    }
    function xoa(code="") {
    $.ajax({
    url: "server.php", // gửi ajax đến file result.php
            type: "POST", // chọn phương thức gửi là post
            dateType: "text", // dữ liệu trả về dạng text
            data: {// Danh sách các thuộc tính sẽ gửi đi
                    action: 'delete',
                    ma:code
            },
            success: function (result) {
                    $('#delete'+code).modal('hide');
                    $('#kq').html(result);
                    $('#success').modal('show');
                    setTimeout(function () {
                    $("#success").modal('hide');
                    }, 2000);
                    getMonHoc();
            }
    });
    }
    function capnhat(code="") {
    $.ajax({
        /*updateten="#uten"+code;
        updatesotinchi="#utinchi"+code;*/
    url: "server.php", // gửi ajax đến file result.php
            type: "POST", // chọn phương thức gửi là post
            dateType: "text", // dữ liệu trả về dạng text
            data: {// Danh sách các thuộc tính sẽ gửi đi
                    action: 'update',
                    ma:code,
                    ten:$('#uten'+code).val(),
                    sotinchi:$('#utinchi'+code).val()
            },
            success: function (result) {
                    $('#delete'+code).modal('hide');
                    $('#kq').html(result);
                    $('#success').modal('show');
                    setTimeout(function () {
                    $("#success").modal('hide');
                    }, 2000);
                    getMonHoc();
            }
    });
    }


</script>
<div class="container" id="content">
    <div style="padding: 10px;"></div>   
    <ol class="breadcrumb">
        <li>
            <a href="#">Panel</a>
        </li>
        <li class="active">Quản lý từ điển môn học</li>
    </ol> 
    <div class="row" style="margin:10px;padding: 15px;">
        <div class="col-md-9">
            <div class="modal fade" id="success">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Thông báo</h4>
                        </div>
                        <div class="modal-body" id="kq">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="add">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Thêm mới môn học</h4>
                        </div>
                        
                        <form action="" onsubmit="return saveMonHoc();;" method="" role="form">

                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="">Mã môn</label>
                                    <input id="ma" type="text" class="form-control" id="" placeholder="" required="true">
                                </div>

                                <div class="form-group">
                                    <label for="">Tên môn</label>
                                    <input id="ten" type="text" class="form-control" id="" placeholder="" required="true">
                                </div>

                                <div class="form-group">
                                    <label for="">Số tín chỉ</label>
                                    <input id="sotinchi" type="number" class="form-control" id="" placeholder="" required="true">
                                </div>



                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-success">Thêm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <fieldset>
                <legend>Nhập mã hoặc tên môn học <div class="pull-right">
                        <span class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" onkeyup="getMonHoc();" id="table_search" class="form-control pull-right" placeholder="Từ khóa">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>


                        </span>  


                    </div></legend>
                

                <div id="result">

                </div>

            </fieldset>
        </div>
        <div class="col-md-3">
            <fieldset>
                <legend>Import từ điển môn học</legend>
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
            </fieldset>
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
