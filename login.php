<?php

include './template/_header.php';

$error=FALSE;

if (isset($_SESSION['id'])) {
   	header("location:index.php");

}
include './Model/Database.php';
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $username=$_POST['username'];
    $password=$_POST['password'];
    $objDb=new Database();
    $objDb->connect();
    if ($objDb->is_user($username, $password)) {
        //die("Login success");
        $usr=$objDb->get_user($username);
        $_SESSION['id']=$usr['id'];
        $_SESSION['name']=$usr['name'];
        $_SESSION['username']=$usr['username'];
        $_SESSION['type']=$usr['type'];
        header("location:index.php");
    }else{
        $error=TRUE;
    }
}
?>
<div class="container">
    <div class="col-md-4 col-md-offset-4" style="padding: 15px;">
        <div class="panel panel-primary">
            <?php
            if ($error) {
            ?>
            <div class="panel-heading text-center" style="font-size: 20px; color: #e67e22">
                Đăng nhập không thành công
            </div>
            <?php
            }else{
                ?>
            <div class="panel-heading text-center" style="font-size: 20px;">
                Login
            </div>
            <?php
            }
            ?>
            
            <form action="" method="POST" role="form">

                <div class="panel-body">

                    <div class="form-group">
                        <label for="">Người dùng</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i style="font-size: 20px;" class="fa fa-user"></i></span>
                            <input type="text" name="username" class="form-control" id="" placeholder="Input username">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Mật khẩu</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <input type="password" name="password" class="form-control" id="" placeholder="Input password">
                        </div>
                    </div>


                </div>
                <div class="panel-footer">
                    <button type="button" data-toggle="modal" href='#lostpass' class="btn btn-default">Quên mật khẩu ?</button>
                    <div class="modal fade" id="lostpass">
                    	<div class="modal-dialog">
                    		<div class="modal-content">
                    			<div class="modal-header">
                    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    				<h4 class="modal-title">Thông báo</h4>
                    			</div>
                    			<div class="modal-body">
                    				Liên hệ người quản trị để lấy lại mật khẩu
                    			</div>
                    			<div class="modal-footer">
                    				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    			</div>
                    		</div>
                    	</div>
                    </div>
                    <button type="submit" class="btn btn-success pull-right" style="font-weight: bold;">Đăng nhập</button>
                </div>
            </form>

        </div>
    </div>
</div>
<?php
include './template/_footer.php';


