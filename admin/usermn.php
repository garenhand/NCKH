<?php
include_once '../template/_header.php';
if (!isset($_SESSION['id'])) {
    header('location:'.siteurl.'login.php');
}else {
    if ($_SESSION['type']!=1) {
        header('location:'.siteurl.'template/permission.php');
    }
}
?>
<script>
    function getuser() {
        $.ajax({
            url: 'server.php',
            type: 'POST',
            dataType: 'text',
            data: {
                action: 'getuser'
            },
        })
                .done(function (result) {
                    $('#result').html(result);
                })

    }
    function adduser() {
        $.ajax({
            url: 'server.php',
            type: 'POST',
            dataType: 'text',
            data: {
                action: 'adduser',
                username: $('#username').val(),
                password: $('#password').val(),
                name: $('#name').val(),
                type: $('#type').val(),
            },
        })
                .done(function (result) {
                    getuser();
                    $('#add').modal('hide');
                    alert(result);
                })

    }
    function updateuser(id) {
        var username='#username'+id;
        var name='#name'+id;
        var type='#type'+id;
        var modal='#edit'+id;
        $.ajax({
            url: 'server.php',
            type: 'POST',
            dataType: 'text',
            data: {
                action: 'updateuser',
                id:id,
                username: $(username).val(),
                name: $(name).val(),
                type: $(type).val(),
            },
        })
                .done(function (result) {
                    
                    $('.modal-backdrop').hide();
                    $(modal).modal('hide');
                    alert(result);
                    getuser();
                })

    }
    function deleteuser(id) {
        var modal='delete'+id;
        $.ajax({
            url: 'server.php',
            type: 'POST',
            dataType: 'text',
            data: {
                action: 'deleteuser',
                id:id
            },
        })
                .done(function (result) {
                    
                    $('.modal-backdrop').hide();
                    $(modal).modal('hide');
                    alert(result);
                    getuser();
                })

    }
    getuser();
</script>
<div class="container">
    <div style="padding: 10px;"></div>   
    <ol class="breadcrumb">
        <li>
            <a href="#">Panel</a>
        </li>
        <li class="active">Quản lý người dùng</li>
    </ol> 
    <div class="row" style="margin:10px;padding: 15px;">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <fieldset>
                <legend>Danh sách người dùng</legend>
                <a style="margin-bottom: 20px;" class="btn btn-success" data-toggle="modal" href='#add'><i class="fa fa-plus"></i> Thêm người dùng mới</a>
                <div class="modal fade" id="add">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Thêm người dùng mới</h4>
                            </div>
                            <form action="">
                                <div class="modal-body">

                                    <div class="form-group">
                                        <label for="">Tài khoản</label>
                                        <input type="text" class="form-control" id="username" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Mật khẩu</label>
                                        <input type="text" class="form-control" id="password" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tên người dùng</label>
                                        <input type="text" class="form-control" id="name" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tên người dùng</label>
                                        <select name="" id="type" class="form-control">
                                            <option value="">-- Nhóm --</option>
                                            <option value="1">Quản trị</option>
                                            <option value="2">Người dùng</option>
                                        </select>
                                    </div>



                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                    <button type="button" onclick="adduser();" class="btn btn-primary">Lưu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="result">
                    
                </div>
            </fieldset>
        </div>
    </div>

</div>

<?php

include '../template/_footer.php';
