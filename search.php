<?php
if (isset($_GET['submit'])) {
    include './Model/Database.php';
    $objDb=new Database();
    $objDb->connect();
   $entry_per_page=5;
   $code=$_GET['code'];
   $name=$_GET['name'];
   $class=$_GET['class'];
   $year=$_GET['year'];
   $term=$_GET['term'];
   $sql="";
   if(!isset($_GET['p'])){
       echo 'ko co phan trang';
       $sql="SELECT * FROM pdf INNER JOIN monhoc ON pdf.subject_code=monhoc.ma WHERE  "
               . "monhoc.ten LIKE '%$name%' AND "
               . "pdf.filename like '%$code%_%$class%_%$year%%$term%' LIMIT $entry_per_page";
       $result=$objDb->getlist($sql);
       
   }else{
       $page=$_GET['p'];
       $offset=--$page*$entry_per_page;
       $sql="SELECT * FROM pdf INNER JOIN monhoc ON pdf.subject_code=monhoc.ma WHERE  "
               . "monhoc.ten LIKE '%$name%' AND "
               . "pdf.filename like '%$code%_%$class%_%$year%%$term%' LIMIT $entry_per_page OFFSET $offset";
       $result=$objDb->getlist($sql);
       if (!$result) {
           $notfound=true;
       }
   }
}
include 'template/_header.php';
?>

<div class="container" id="content" style="padding-top: 10px;padding-bottom: 20px;">
		<div class="col-md-12" style=" border: #ddd solid 1px; padding: 15px; padding-top: 10px;">
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
                                                                <input type="text" name="code" class="form-control" id="" placeholder="Nhập mã">
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Tên môn học</label>
							<div class="input-group">
								<span class="input-group-addon"><i style="font-size: 20px;" class="fa fa-book"></i></span>
                                                                <input name="name" type="text" class="form-control" id="" placeholder="Nhập tên">
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label for="">Nhóm môn học</label>
							<div class="input-group">
								<span class="input-group-addon"><i style="font-size: 20px;" class="fa fa-group"></i></span>
                                                                <input name="class" type="text" class="form-control" id="" placeholder="Nhóm">
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label for="">Năm học</label>
							<div class="input-group">
								<span class="input-group-addon"><i style="font-size: 20px;" class="fa fa-calendar"></i></span>
								<select name="year" id="input" class="form-control">
									<option value="">--Chọn--</option>
									<?php 
                                                                        for ($index =date('Y') ; $index >= 1956; $index--) {
                                                                            echo "<option value=\"".$index."\">".$index."</option>";
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
								<select name="term" id="input" class="form-control">
									<option value="">-Chọn-</option>
									<option value="01">1</option>
									<option value="02">2</option>
									<option value="03">3</option>
								</select>
							</div>
						</div>
					</div>
					
				
					

					
				
					<div class="col-md-1" style="">
							<div style="margin-bottom: 22px;"></div>

                                                        <button type="submit" name="submit" class="btn btn-block btn-success" style="font-weight: bold;"><i class="fa fa-search"></i></button>
					</div>
				</form>
			</div>


			<div class="col-md-12">
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong>Có 200 kết quả phù hợp cho </strong> <br>
					Alert body ... <br>
					Alert body ... <br>
					Alert body ...
				</div>
			</div>
			<div class="col-md-12">
				<div class="alert alert-warning">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong>Không có kết quả nào cho </strong> <br>
					Alert body ... <br>
					Alert body ... <br>
					Alert body ...
				</div>
			</div>
                    <?php
                        if (isset($notfound) && $notfound) {
                            ?>
                        <div class="col-md-12">
                                    <div class="alert alert-danger">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <strong>Trang bạn tìm kiếm không có</strong>
                                    </div>
                            </div>
                    <?php
                        }
                    ?>
			<div class="col-md-12">
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong>Chưa nhập từ khóa tìm kiếm </strong>
				</div>
			</div>

                     <?php
                        if (!empty($result)) {
                    ?> 
                    
			<div class="col-md-12">
				<table class="table table-hover table-bordered table-striped">
					<thead>
						<tr>
							<th>STT</th>
							<th>Mã</th>
							<th>Tên Môn Học</th>
							<th>Nhóm</th>
							<th>Năm học</th>
							<th>Học kì</th>
							<th>Số tín chỉ</th>
							<th>Xem chi tiết</th>
						</tr>
					</thead>
					<tbody>
                                                <?php
                                                    foreach ($result as $row) {
                                                        $filename=$row['filename'];
                                                        $tenfile= explode('_', $filename);               
                                                ?>
						<tr>
							<td>1</td>
							<td><?php echo $tenfile[0]; ?></td>
							<td><?php echo $row['ten']; ?></td>
							<td><?php echo $tenfile[1]; ?></td>
                                                        <td><?php echo substr($tenfile[2], -(strlen($tenfile[2])),4); ?></td>
                                                        <td><?php echo substr($tenfile[2],-6,2) ?></td>
							<td><?php echo $row['sotinchi'];?></td>
                                                        <td class="text-center"><a href="uploads/<?php echo $row['filename']?>"><button type="button" class="btn btn-sm btn-success">Xem</button></a></td>
						</tr>
                                                
                                                <?php
                                                                    }
                                                ?>
					</tbody>
				</table>
			</div>
                    <?php
                                                }
                                            ?>

		</div>
	</div>
<?php
include 'template/_footer.php';