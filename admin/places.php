<?php

	include_once('header.php');

	if (isset($_GET['delete'])) {	//删除
		$places_id = $_GET['delete'];
		$DB = MySql::getInstance();
		$sql = "delete from places where id = " . $places_id;
		$DB->query($sql);
		echo '<div class="alert alert-success"> 删除成功！ </div>';
	}
?>
 
 <button style="float:right" class="btn btn-primary" type="button" onclick="location.href='places-edit.php'">添加景点</button>

    <div class="tab-pane" id="tab2">
      	<div>
			<table class="table table-striped table-hover">
			  <thead>
			    <th width="10%">ID</th>
			    <th width="20%">城市</th>
			    <th width="60%">景点名</th>
			    <th width="10%">操作</th>
			  </thead>
			  <?php
			  	//列出所有景点
			  	$DB = MySql::getInstance();
				$sql = "SELECT * FROM  places";
				$places = $DB->query($sql);
				while($row = $DB->fetch_array($places)):

				$sql = "select name from city where id=" . $row['cityid'];
				$city = $DB->fetch_array($DB->query($sql));
			?>
			  <tr>
			    <td><?php echo $row['id'];?></td>
			    <td><?php echo $city['name'];?></td>
			    <td><?php echo $row['name'];?></td>
			    <td>
				    <div class="btn-group">
					  <button class="btn" onclick="location.href='places-edit.php?update=<?php echo $row['id']; ?>'">修改</butto>
					  <button class="btn" onclick="location.href='places.php?delete=<?php echo $row['id']; ?>'">删除</butto>
					</div>
				</td>
			  </tr>
			<?php endwhile; ?>
			</table>
		</div>
    </div>


<?php
	include_once('footer.php');
?>