<?php

	include_once('header.php');


	if (isset($_GET['updata'])) {	//修改
		$city_id = $_GET['updata'];
		$city_newname = $_GET['newname'];
		$DB = MySql::getInstance();
		$sql = "update sort set name = '". $city_newname . "'where id =" . $city_id;
		$citys = $DB->query($sql);
		echo '<div class="alert alert-success"> 更新成功！ </div>';
	}elseif (isset($_GET['delete'])) {	//删除
		$city_id = $_GET['delete'];
		$DB = MySql::getInstance();
		$sql = "delete from sort where id = " . $city_id;
		$DB->query($sql);
		echo '<div class="alert alert-success"> 删除成功！ </div>';
	}elseif (isset($_GET['add'])) {		//添加
		$city_name = $_GET['add'];
		$DB = MySql::getInstance();
		$sql = "insert into sort values(null,'" . $city_name."')";
		$citys = $DB->query($sql);
		echo '<div class="alert alert-success"> 添加成功！ </div>';
	}
?>
<script language="javascript">
var cid;
function showmodal(id,oldname){
		cid=id;
      $("#cityid").text(id);
      $("#oldcityname").text(oldname);
}
function update(){
	location.href="sort.php?updata="+ cid +"&newname=" + $("#newcityname").val();
}
</script>

    <div class="tab-pane" id="tab2">
      	<div>
			<table class="table table-striped table-hover">
			  <thead>
			    <th width="10%">ID</th>
			    <th width="70%">分类</th>
			    <th width="10%">操作</th>
			  </thead>
			  <?php
			  	//列出所有分类
			  	$DB = MySql::getInstance();
				$sql = "SELECT * FROM  sort";
				$citys = $DB->query($sql);
				while($row = $DB->fetch_array($citys)):
			?>
			  <tr>
			    <td><?php echo $row['id'];?></td>
			    <td><?php echo $row['name'];?></td>
			    <td>
				    <div class="btn-group">
				    	<a href="#myModal" role="button" class="btn" data-toggle="modal" onclick="showmodal(<?php echo $row['id'];?>,'<?php echo $row['name'];?>')" >修改</a>
					  <button class="btn" onclick="location.href='sort.php?delete=<?php echo $row['id']; ?>'">删除</button>
					</div>
				</td>
			  </tr>
			<?php endwhile; ?>
			</table>
		</div>
    </div>
    <hr>
    <div id="city-add">
    	<h4>添加分类：</h4>
		<form class="form-horizontal" action="sort.php" method="get">
		  <div class="control-group">
		    <label class="control-label">分类名：</label>
		    <div class="controls">
		      <input type="text" name="add" id="add" placeholder="重庆">
		    </div>
		  </div>
		  <div class="control-group">
		    <div class="controls">
		      <button type="submit" class="btn" >添加</button>
		    </div>
		  </div>
		</form>
    </div>
<hr>


<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">修改</h3>
  </div>
  <div class="modal-body">
    <p>将 <span id="cityid" class="label">1</span> ：<span id="oldcityname" class="label label-info">重庆</span> 修改为 ：<input id="newcityname" type="text"></p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
    <button class="btn btn-primary" onclick="update()">保存</button>
  </div>
</div>

<?php
	include_once('footer.php');
?>