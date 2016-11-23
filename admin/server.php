<?php

function time_ago($created_time) {
    date_default_timezone_set('Asia/Calcutta'); //Change as per your default time
    $str = strtotime($created_time);
    $today = strtotime(date('Y-m-d H:i:s'));

    // It returns the time difference in Seconds...
    $time_differnce = $today - $str;

    // To Calculate the time difference in Years...
    $years = 60 * 60 * 24 * 365;

    // To Calculate the time difference in Months...
    $months = 60 * 60 * 24 * 30;

    // To Calculate the time difference in Days...
    $days = 60 * 60 * 24;

    // To Calculate the time difference in Hours...
    $hours = 60 * 60;

    // To Calculate the time difference in Minutes...
    $minutes = 60;

    if (intval($time_differnce / $years) > 1) {
        return intval($time_differnce / $years) . " năm trước";
    } else if (intval($time_differnce / $years) > 0) {
        return intval($time_differnce / $years) . " năm trước";
    } else if (intval($time_differnce / $months) > 1) {
        return intval($time_differnce / $months) . " tháng trước";
    } else if (intval(($time_differnce / $months)) > 0) {
        return intval(($time_differnce / $months)) . " tháng trước";
    } else if (intval(($time_differnce / $days)) > 1) {
        return intval(($time_differnce / $days)) . " ngày trước";
    } else if (intval(($time_differnce / $days)) > 0) {
        return intval(($time_differnce / $days)) . " ngày trước";
    } else if (intval(($time_differnce / $hours)) > 1) {
        return intval(($time_differnce / $hours)) . " giờ trước";
    } else if (intval(($time_differnce / $hours)) > 0) {
        return intval(($time_differnce / $hours)) . " giờ trước";
    } else if (intval(($time_differnce / $minutes)) > 1) {
        return intval(($time_differnce / $minutes)) . " phút trước";
    } else if (intval(($time_differnce / $minutes)) > 0) {
        return intval(($time_differnce / $minutes)) . " phút trước";
    } else if (intval(($time_differnce)) > 1) {
        return intval(($time_differnce)) . " giây trước";
    } else {
        return "Vài giây trước";
    }
}

function filter($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../Model/Database.php';
    $entry_per_page = 10;
    $objDb = new Database();
    $objDb->connect();
    $method = $_POST['action'];

    if ($method == 'add') {
        $data = array(
            'ma' => filter($_POST['ma']),
            'ten' => filter($_POST['ten']),
            'sotinchi' => filter($_POST['sotinchi'])
        );
        if ($objDb->insert('monhoc', $data)) {
            echo "Thêm môn học thành công";
        } else {
            echo "Thêm môn học thất bại, có thể do trùng mã ";
        }
    } elseif ($method == 'get') {
        $key = filter($_POST['key']);
        $offset = $_POST['page'] * $entry_per_page;
        $sql = "SELECT * FROM monhoc WHERE "
                . "ma LIKE '%$key%' "
                . "OR ten LIKE '%$key%' ";
        $records = $objDb->count_num_row($sql);
        $page = ceil($records / $entry_per_page);
        echo 'Số kết quả trả về ' . $records;

        $sql = "SELECT * FROM monhoc WHERE "
                . "ma LIKE '%$key%' "
                . "OR ten LIKE '%$key%' "
                . "LIMIT $entry_per_page "
                . "OFFSET $offset";
        $result = $objDb->getlist($sql);
        if ($result) {
            ?>
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Mã môn</th>
                        <th>Tên môn</th>
                        <th>Số tín chỉ</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <?php
                foreach ($result as $row) {
                    ?>
                    <tr>
                        <td><?php echo $row['ma'] ?></td>
                        <td><?php echo $row['ten'] ?></td>
                        <td><?php echo $row['sotinchi'] ?></td>
                        <td class="text-center">
                            <a class="btn btn-danger" data-toggle="modal" href="#delete<?php echo $row['ma'] ?>">Xóa</a>
                            <div class="modal fade" id="delete<?php echo $row['ma'] ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title">Xóa môn học</h4>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có muốn xóa môn : <?php echo $row['ten'] ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                            <button type="button" onclick="xoa('<?php echo $row['ma'] ?>')" class="btn btn-danger">Xóa</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="btn btn-warning" data-toggle="modal" href="#edit<?php echo $row['ma'] ?>">Sửa</a>
                            <div class="modal fade text-left" id="edit<?php echo $row['ma'] ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title">Sửa môn học</h4>
                                        </div>
                                        <form action="" method="POST" role="form">

                                            <div class="modal-body">

                                                <div class="form-group">
                                                    <label for="">Mã Môn học</label>
                                                    <input type="text" class="form-control" disabled="" value="<?php echo $row['ma'] ?>" id="" placeholder="Nhập mã môn học">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Tên môn</label>
                                                    <input type="text" class="form-control" id="uten<?php echo $row['ma'] ?>" value="<?php echo $row['ten'] ?>" id="" placeholder="Nhập tên môn học">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Số tín chỉ</label>
                                                    <input type="text" class="form-control" id="utinchi<?php echo $row['ma'] ?>" value="<?php echo $row['sotinchi'] ?>" id="" placeholder="Số tín chỉ">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                                <button type="button" onclick="capnhat('<?php echo $row['ma'] ?>')" class="btn btn-success">Lưu</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                echo '</table>';
                ?>
                <div>Trang <?php echo $curent = ($_POST['page']) + 1 . " / " . $page; ?>  </div>
                <div class="pull-right"><a class="btn btn-primary"  data-toggle="modal" href='#add'><i class="fa fa-plus"></i> Thêm môn học</a></div>
                <ul class="pagination">
                    <?php
                    $curent = $curent - 1;
                    if ($curent != 0) {
                        ?>
                        <li><a href="javascript:void(0);" onclick="getMonHoc(0)">Đầu tiên</a></li>

                        <li><a href="javascript:void(0);" onclick="getMonHoc(<?php echo $curent - 1 ?>)">Trang trước</a></li>

                        <?php
                    }
                    ?>
                    <?php
                    if ($curent != $page - 1) {
                        ?>
                        <li><a href="javascript:void(0);" onclick="getMonHoc(<?php echo $curent + 1 ?>)">Trang sau</a></li>
                        <li><a href="javascript:void(0);" onclick="getMonHoc(<?php echo $page - 1 ?>)">Trang cuối</a></li>

                        <?php
                    }
                    ?>
                </ul>
                <?php
            } else {
                ?>
                <div>Không có kết quả hơn lệ</div>
                <div class="pull-right"><a class="btn btn-primary"  data-toggle="modal" href='#add'><i class="fa fa-plus"></i> Thêm môn học</a></div>
                <?php
            }
        } elseif ($method == 'delete') {
            $ma = filter($_POST['ma']);
            $where = "ma='$ma'";
            if ($objDb->delete('monhoc', $where)) {
                echo "Xóa Thành Công";
            } else {
                echo $objDb->show_error();
                echo "Xóa Thất Bại";
            }
        } else if ($method == 'update') {
            $ma = filter($_POST['ma']);
            $ten = filter($_POST['ten']);
            $sotinchi = filter($_POST['sotinchi']);
            $data = array(
                'ten' => $ten,
                'sotinchi' => $sotinchi
            );
            $where = "ma='$ma'";
            if ($objDb->update('monhoc', $data, $where)) {
                echo " Cập Nhật thành công";
            } else {
                echo " Cập Nhật thất bại";
            }
        } else if ($method == 'getpdf') {
            $code = filter($_POST['code']);
            $name = filter($_POST['name']);
            $class = filter($_POST['class']);
            $year = filter($_POST['year']);
            $term = filter($_POST['term']);
            $page = filter($_POST['page']);
            $offset = $page * $entry_per_page;
            $sql = "SELECT * FROM pdf INNER JOIN monhoc ON pdf.subject_code=monhoc.ma WHERE  "
                    . "monhoc.ten LIKE '%$name%' AND "
                    . "pdf.filename like '%$code%_%$class%_%$year%%$term%' LIMIT $entry_per_page OFFSET $offset";
            $result = $objDb->getlist($sql);
            if ($result) {
                ?>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Mã môn</th>
                            <th>Tên Môn học</th>
                            <th>Nhóm môn học</th>
                            <th>Năm học</th>
                            <th>Học kì</th>
                            <th>Số tín chỉ</th>
                            <th>Upload</th>
                            <th>Xem chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($result as $row) {
                            $filename = $row['filename'];
                            $tenfile = explode('_', $filename);
                            ?>
                            <tr>
                                <td><?php echo $row['ma'] ?></td>
                                <td><?php echo $row['ten'] ?></td>
                                <td><?php echo $tenfile[1] ?></td>
                                <td><?php echo substr($tenfile[2], -(strlen($tenfile[2])), 4); ?></td>
                                <td><?php echo substr($tenfile[2], -6, 2) ?></td>
                                <td><?php echo $row['sotinchi']; ?></td>
                                <td><?php echo time_ago($row['upload_date']); ?></td>
                                <td><a href="uploads/<?php echo $row['filename'] ?>"><button type="button" class="btn btn-sm btn-success">Xem</button></a></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            }
        } else if ($method == 'getuser') {
            $where = "1";
            $records = $objDb->select('user', $where);
            ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Tài khoản</th>
                        <th>Tên người dùng</th>
                        <th>Nhóm</th>
                        <th>Thao tác</th>
                    </tr>
                <tbody
                <?php
                foreach ($records as $row) {
                    ?>
                        <tr>
                            <td><?php echo $row['username'] ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['type'] == 1 ? "Admin" : "Người dùng"; ?></td>
                            <td>
                                <a class="btn btn-warning" data-toggle="modal" href="#edit<?php echo $row['id']; ?>">Sửa</a>
                                <div class="modal fade" id="edit<?php echo $row['id']; ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">Thay đổi thông tin người dùng</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="">Tài khoản</label>
                                                    <input type="text" class="form-control" value="<?php echo $row['username']; ?>" id="username<?php echo $row['id'] ?>" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Tên người dùng</label>
                                                    <input type="text" class="form-control" value="<?php echo $row['name']; ?>" id="name<?php echo $row['id'] ?>" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Tên người dùng</label>
                                                    <select name="" id="type<?php echo $row['id'] ?>" class="form-control">
                                                        <option value="">-- Nhóm --</option>
                                                        <option value="1" <?php echo $row['type'] == 1 ? "selected" : "" ?> >Admin</option>
                                                        <option value="2" <?php echo $row['type'] == 2 ? "selected" : "" ?> >Người dùng</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="button" onclick="updateuser(<?php echo $row['id'] ?>)" class="btn btn-primary">Lưu lại</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a class="btn btn-primary" data-toggle="modal" href="#chpw<?php echo $row['id']; ?>">Thay đổi mật khẩu</a>
                                <div class="modal fade" id="chpw<?php echo $row['id']; ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">Thay đổi mật khẩu</h4>
                                            </div>
                                            <div class="modal-body">
                                                <legend>Người dùng <?php echo $row['name']; ?></legend>

                                                <div class="form-group">
                                                    <label for="">Mật khẩu mới</label>
                                                    <input type="text" id="newpass<?php echo $row['id'] ?>" class="form-control" id="" placeholder="">
                                                </div>



                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                                <button type="button" class="btn btn-primary">Lưu</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <a class="btn btn-danger" data-toggle="modal" href="#delete<?php echo $row['id']; ?>">Xóa</a>
                                <div class="modal fade" id="delete<?php echo $row['id']; ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">Thông báo</h4>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có thực sự muốn xóa người dùng: <?php echo $row['name'] ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                                <button type="button" onclick="deleteuser(<?php echo $row['id'] ?>)" class="btn btn-danger">Xóa</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php
        } else if ($method == 'adduser') {
            $username = filter($_POST['username']);
            $name = filter($_POST['name']);
            $pass = md5($_POST['password']);
            $type = $_POST['type'];
            $data = array(
                'username' => $username,
                'name' => $name,
                'password' => $pass,
                'type' => $type
            );
            if ($objDb->insert('user', $data)) {
                echo "Thêm người dùng thành công";
            } else {
                echo $objDb->show_error();
                echo "Thêm người dùng thất bại";
            }
        } else if ($method == 'updateuser') {
            $id = filter($_POST['id']);
            $name = filter($_POST['name']);
            $username = filter($_POST['username']);
            $type = filter($_POST['type']);
            $data = array(
                'name' => $name,
                'type' => $type,
                'username' => $username
            );
            $where = "id= '$id'";
            if ($objDb->update('user', $data, $where)) {
                echo 'Cập nhật thành công';
            } else {
                echo $objDb->show_error();
                echo "Cập nhật thất bại, có thể do trùng username!";
            }
        } else if ($method == 'chpw') {
            $id = filter($_POST['id']);
            $password = md5($_POST['password']);
            $data = array(
                'password' => $password
            );
            $where = "id= '$id'";
            if ($objDb->update('user', $data, $where)) {
                echo 'Thay đổi mật khẩu thành công';
            } else {
                echo $objDb->show_error();
                echo "Thay đổi mật khẩu thất bại";
            }
        } else if ($method == 'deleteuser') {
            $id = filter($_POST['id']);
            $where = "id= '$id'";
            if ($objDb->delete('user', $where)) {
                echo 'Xóa người dùng thành công';
            } else {
                echo $objDb->show_error();
                echo "Xóa người dùng thất bại";
            }
        } else if ($method == 'updatepass') {
            $id = filter($_POST['id']);
            $old = filter($_POST['old']);
            $new = filter($_POST['new']);
            $new2 = filter($_POST['new2']);
            $pass = md5($old);
            $sql = "SELECT id FROM user WHERE id=$id AND password='$pass'";
            if ($objDb->count_num_row($sql) > 0) {
                if ($new === $new2) {
                    $newpass = md5($new);
                    $table = 'user';
                    $data = array(
                        'password' => $newpass
                    );
                    $where = "id=$id";
                    if ($objDb->update($table, $data, $where)) {
                        echo "Thay đổi mật khẩu thành công";
                    } else {
                        echo "Thay đổi mật khẩu thất bại";
                    }
                } else {
                    echo "Mật khẩu bạn vừa nhập không trùng khớp";
                }
            } else {
                echo 'Mật khẩu cũ của bạn không đúng';
            }
        } else if ($method == 'updatename') {
            $name = filter($_POST['name']);
            $id = filter($_POST['id']);
            if ($name == "" || $name == NULL) {
                echo "Không được để trống trường tên, cập nhật thất bại";
            } else {
                $table = 'user';
                $data = array(
                    'name' => $name
                );
                $where = "id=$id";
                if ($objDb->update($table, $data, $where)) {
                        echo "Thay đổi tên thành công";
                    } else {
                        echo "Thay đổi tên khẩu thất bại";
                    }
            }
        }
    } else {
        include '../template/permission.php';
    }