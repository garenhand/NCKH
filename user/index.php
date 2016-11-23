<?php
include_once '../template/_header.php';
if (!isset($_SESSION['id'])) {
    header('location:' . siteurl . 'login.php');
}
include_once '../Model/Database.php';
$objDb = new Database();
$objDb->connect();
function filter($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if ($_SERVER['REQUEST_METHOD']=='POST') {
  $newname=filter($_POST['newname']);
  if ($newname==""||$newname==NULL) {
    $message="Tên không được để trống";
  }else{
      $id=$_SESSION['id'];
      $table='user';
      $data=array(
        'name'=>$newname  
      );
      $where="id=$id";
      if ($objDb->update($table, $data, $where)) {
          $message="Cập nhật tên thành công";
      }else{
          $message="Cập nhật tên thất bại";
      }
  }
}

$user = $objDb->get_user($_SESSION['username']);
?>
<script>
    function updatepassword(id) {
      $.ajax({
      url: '../admin/server.php',
      type: 'POST',
      dataType: 'text',
      data: {
        action:'updatepass',
        id: id,
        old:$('#oldpass').val(),
        new:$('#newpass').val(),
        new2:$('#newpass2').val()
      },
    })
    .done(function(result) {
      $('#chpw').modal('hide');
      alert(result);
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
    return false;
    }
    
</script>
<div class="container">
    <div style="padding: 10px;"></div>

    <ol class="breadcrumb">
        <li class="active">Hồ sơ cá nhân</li>
    </ol>
    <div class="row">
        <?php
        if (isset($message)) {
            ?>
        <div class="well">
            <?php echo $message;
            ?>
        </div>
        <?php
        }
        ?>
        <div class="col-md-6">
            <h3>Thông tin chi tiết</h3>
            <table class="table table-bordered table-hover">
                <tbody>
                    <tr>
                        <td>ID</td>
                        <td><?php echo $user['id']; ?></td>
                    </tr>
                    <tr>
                        <td>Tên đăng nhập</td>
                        <td><?php echo $user['username']; ?></td>
                    </tr>
                    <tr>
                        <td>Tên hiển thị</td>
                        <td><?php echo $user['name']; ?></td>
                    </tr>
                    <tr>
                        <td>Nhóm người dùng</td>
                        <td><?php echo $user['type'] != 1 ? "User" : "Admin"; ?></td>
                    </tr>
                </tbody>
            </table>  
        </div>

        <div class="col-md-6">
            <h3>Thao tác</h3>
            <a class="btn btn-primary" data-toggle="modal" href='#chpw'>Đổi mật khẩu</a>
            <div class="modal fade" id="chpw">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Thay đổi mật khẩu</h4>
                        </div>
                        <form action="" onsubmit="return updatepassword(<?php echo $user['id'] ?>);" method="POST" role="form">
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="">Mật khẩu cũ</label>
                                    <input type="password" id="oldpass" class="form-control"  required="">
                                </div>

                                <div class="form-group">
                                    <label for="">Mật khẩu mới</label>
                                    <input type="password"  class="form-control" id="newpass"  required="">
                                </div>

                                <div class="form-group">
                                    <label for="">Nhập lại mật khẩu mới</label>
                                    <input type="password" class="form-control" id="newpass2"  required="">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-success">Lưu</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <a class="btn btn-primary" data-toggle="modal" href='#chname'>Thay đổi tên hiển thị</a>
            <div class="modal fade" id="chname">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Thay đổi tên hiển thị</h4>
                  </div>
                    <form action="" method="POST" role="form">

                  <div class="modal-body">
                    
                      <div class="form-group">
                        <label for="">Tên hiển thị mới</label>
                        <input type="text" class="form-control" name="newname" value="<?php echo $user['name'] ?>" placeholder="">
                      </div>
                    
                      
                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-danger">Lưu</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            
            
            
        </div>
    </div>
</div>
<?php
include '../template/_footer.php';
?>
