<?php
include 'template/_header.php';
if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
?>
<script>
    function getpdf(p = 0) {
        $.ajax({
            url: "admin/server.php", // gửi ajax đến file result.php
            type: "POST", // chọn phương thức gửi là post
            dateType: "text", // dữ liệu trả về dạng text
            data: {// Danh sách các thuộc tính sẽ gửi đi
                action: 'getpdf',
                code: $("#ma").val() == undefined ? '%' : $("#ma").val(),
                name: $("#name").val() == undefined ? '%' : $("#name").val(),
                class: $("#class").val() == undefined ? '%' : $("#class").val(),
                year: $("#year").val() == undefined ? '%' : $("#year").val(),
                term: $("#term").val() == undefined ? '%' : $("#term").val(),
                page: p
            },
            success: function (result) {
                $('#result').html(result);
            }
        });
    }
    getpdf();
    function reset() {
        $('input').val("");
        getpdf();
    }

</script>
<div class="container" id="content" style="padding-top: 10px;padding-bottom: 20px;">
    <div class="col-md-12" style=" padding: 15px; padding-top: 10px;">
        <div class="title">
            Tìm kiếm điểm thi
        </div>
        <div class="col-md-12">
            <form action="" method="GET" role="form">

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Mã môn học</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-barcode" aria-hidden="true"></i></i></span>
                            <input type="text" id="ma" name="code" class="form-control" placeholder="Nhập mã">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Tên môn học</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i style="font-size: 20px;" class="fa fa-book"></i></span>
                            <input name="name" id="name" type="text" class="form-control" placeholder="Nhập tên">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Nhóm môn học</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i style="font-size: 20px;" class="fa fa-group"></i></span>
                            <input name="class" id="class" type="text" class="form-control" placeholder="Nhóm">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Năm học</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i style="font-size: 20px;" class="fa fa-calendar"></i></span>
                            <select name="year" id="year" class="form-control">
                                <option value="">--Chọn--</option>
                                <?php
                                for ($index = date('Y'); $index >= 1956; $index--) {
                                    echo "<option value=\"" . $index . "\">" . $index . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Học kì</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i style="font-size: 20px;" class="fa fa-tag"></i></span>
                            <select name="term" id="term" class="form-control">
                                <option value="">-Chọn-</option>
                                <option value="01">1</option>
                                <option value="02">2</option>
                                <option value="03">3</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-1" style="">

                    <button type="button" onclick="getpdf();" name="submit" class="btn btn-block btn-success" style="font-weight: bold;"><i class="fa fa-search"></i></button>
                    <button type="button" onclick="reset();" name="submit" class="btn btn-block btn-default" style="font-weight: bold;"><i class="fa fa-refresh"></i></button>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <div id="result">

            </div>
        </div>
    </div>
</div>
    <?php
    include 'template/_footer.php';
    