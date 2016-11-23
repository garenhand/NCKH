<?php
include_once '../template/_header.php';
if (!isset($_SESSION['id'])) {
    header('location:'.siteurl.'login.php');
}else {
    if ($_SESSION['type']!=1) {
        header('location:'.siteurl.'template/permission.php');
    }
}  
    $hasuploaded=0;
    $error=array();

if ($_SERVER['REQUEST_METHOD']=='POST') {
    include '../Model/Database.php';
    $objDb=new Database();
    $objDb->connect();
    $target_dir = "../uploads/";
    $total=count($_FILES['pdf']['name']);
    for ($index = 0; $index < $total; $index++) {
        $target_file = $target_dir . basename($_FILES["pdf"]["name"][$index]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $errors="";
        if (file_exists($target_file)) {
            $errors.= " đã tồn tại";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["pdf"]["size"][$index] > 5000000) {
            $errors.= " quá nặng";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "pdf" ) {
            $errors.= " sai định dạng";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            array_push($error, basename($_FILES["pdf"]["name"][$index]).$errors);
        } else {
            if (move_uploaded_file($_FILES["pdf"]["tmp_name"][$index], $target_file)) {
                $mh=explode('_',basename($_FILES["pdf"]["name"][$index]));
                $mamh=$mh[0];
                $data=array(
                    'filename'=>basename($_FILES["pdf"]["name"][$index]),
                    'subject_code'=>$mamh,
                    'id_user'=>1
                );
                $table='pdf';
                $objDb->insert($table,$data);
                $hasuploaded++;
                
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}
?>
<script>
    function count() {
    var c=document.forms["uploadpdf"]["pdf[]"].files.length;
    var count=document.getElementById('count');
    count.innerHTML="Có " +c+ " files được chọn";
}
</script>
<div class="container" id="content">

    <div class="row" style="margin:10px; border: #ddd solid 1px; padding: 15px;">
        <div class="col-md-12" style="margin-top: 20px;">
            <div class="title">
                Upload môn học
            </div>
        </div>
        
        <div class="col-md-4 col-md-offset-4">
        <?php
        if ($hasuploaded>0) {
        ?>
            <div class="alert alert-success">
                Có <?php echo $hasuploaded ?> files đã được upload
            </div>
        <?php
        }
        ?>
        <?php
        if (count($error)>0) {
        ?>
            <div class="alert alert-warning">
                <b>Có <?php echo count($error) ?> không được upload</b><br>
                <?php
                        $i=0;
                        foreach ($error as $value) {
                            echo ++$i;
                            echo ". ".$value."<br>";
                        }
                ?>
            </div>
        <?php
        }
        ?>
        
            <form name="uploadpdf" action="" method="POST" role="form" enctype="multipart/form-data">
                <label class="control-label"><i class="fa fa-file" aria-hidden="true"></i>  Your File</label>
                <input type="file" name="pdf[]" onchange="count();" id="unubo" class="filestyle" multiple="" data-buttonText=" Select a File">
                <div id="count" style="padding: 10px;">
                    
                </div>
                <button type="submit" class="btn btn-info btn-lg" style="margin-top: 10px;">
                    <i class="fa fa-upload" aria-hidden="true"></i> Upload
                </button>
            </form>
        </div>
    </div>
</div>

<?php
include '../template/_footer.php';
