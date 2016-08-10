<?php

function getExt($filename) {
    //strrpos()函数查找字符串在另一个字符串中最后一次出现的位置。如果成功，则返回位置，否则返回 false。
    $ext = strtolower ( substr ( $filename, strrpos ( $filename, '.' ) + 1 ) );
    return $ext;
}


	include_once('header.php');

	$headImg = null;

	if (isset($_POST["myContent"])) {

		


		//如果有提交数据
		print "<script language=\"JavaScript\">alert(\"操作成功！\");</script>"; 
		
		$desc = $_POST["myContent"];
		$cityid = $_POST["cityid"];
		$sortid = $_POST["sortid"];
		$pname =  $_POST["pname"];
		$pexcerpt = $_POST["pexcerpt"];
		$postion = $_POST["postion"];


		$DB = MySql::getInstance();


		echo $_FILES["file"]["error"];
			if ($_FILES["file"]["error"] > 0)
			  {
			 	 // echo "Error: " . $_FILES["file"]["error"] . "<br />";
			  	echo "上传图片失败！";
			  }
			else
			  {
				  // echo "Upload: " . $_FILES["file"]["name"] . "<br />";
				  // echo "Type: " . $_FILES["file"]["type"] . "<br />";
				  // echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
				  // echo "Stored in: " . $_FILES["file"]["tmp_name"];

				  //有上传的文件 - SaeStorage
				  $s = new SaeStorage();
				  $s->upload( 'main' , $_GET['update'] . '.' . getExt($_FILES["file"]["name"]) , $_FILES["file"]["tmp_name"] );
				  $headImg = $s->getUrl( 'main' , $_GET['update'] . '.' . getExt($_FILES["file"]["name"]) );
			  }

		

		if (isset($_GET['update'])){	//如果是更新

			// $sql = "SELECT headimg FROM  places where id = " . $update;

			// $DB->query($sql);
			// $places = $DB->fetch_array($places);
			// echo $places['headimg'];
			
                        
                  	//如果有上传文件，执行不同的SQL
                        if ($_FILES["file"]["error"] > 0)
                        {			
                        
                          $sql = "update places set name = '"
                          . $pname 
                          . "', cityid=" . $cityid 
                          . ",  postion = '" . $postion 
                          . "', sortid = " . $sortid 
                          . " , excerpt = '" . $pexcerpt 
                          . "', description = '". $desc 
                          . "'  where id =" . $_GET['update'];
                        
                        }
                  	else	//没有上传文件
                        {
                          $sql = "update places set name = '"
                          . $pname 
                          . "', cityid=" . $cityid 
                          . ",  postion = '" . $postion 
                          . "', sortid = " . $sortid 
                          . " , excerpt = '" . $pexcerpt 
                          . "', description = '". $desc 
                          . "', headimg= '". $headImg
                          . "'  where id =" . $_GET['update'];
                        }


		}
		else
		{		//否则就是新增


			
			$sql = "insert into places values(null,'". $pname ."',". $cityid .", '". $postion . "' ,'" . $pexcerpt . " ' ,  '". $desc ."', ". $sortid .", '". $headImg ."' )";
			//header("location: places.php");	//跳到列表页
		}

		$places = $DB->query($sql);
		header("location: places.php");	//跳到列表页
	}

	if (isset($_GET['update'])) {	//如果为更新某项
		$update = $_GET['update'];
		$DB = MySql::getInstance();
		$sql = "SELECT * FROM  places where id = " . $update;
		$places = $DB->query($sql);
		$places = $DB->fetch_array($places);
	}else{
		//否则就为添加新景点
		$places = null;
	}

?>

<?php 
	if (isset($update)) {
		echo "<h3>编辑景点：</h3>";
	}
	else
	{
		echo "<h3>添加景点：</h3>";
	}



?>
<form method="post" enctype="multipart/form-data">

	<div style="float:left;">
		<label class="control-label">景点名称：</label>
		<input type="text" name="pname" id="pname" value="<?php echo $places['name']; ?>">	
	</div>
	<div style="float:left; margin-left:30px;">
		<label class="control-label">所属城市：</label>
		<select name="cityid">
			<?php
			  	//列出所有城市
			  	$DB = MySql::getInstance();
				$sql = "SELECT * FROM  city";
				$citys = $DB->query($sql);
				while($row = $DB->fetch_array($citys)):
			?>
			<option <?php if($row['id']==$places['cityid']) echo "selected";?> value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
			<?php endwhile; ?>
	    </select>
	</div>
	<div style="float:left; margin-left:30px;">
		<label class="control-label">所属分类：</label>
		<select name="sortid">
			<?php
			  	//列出所有分类
			  	$DB = MySql::getInstance();
				$sql = "SELECT * FROM  sort";
				$citys = $DB->query($sql);
				while($row = $DB->fetch_array($citys)):
			?>
			<option <?php if($row['id']==$places['sortid']) echo "selected";?> value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
			<?php endwhile; ?>
	    </select>
	</div>
	<br><br><br><br>
	<div style="float:left; margin-left:30px;">
		<label class="control-label">坐标：</label>
		<input type="text" name="postion" value="<?php echo $places['postion']; ?>" >
	</div>
	<div style="float:left; margin-left:30px;">
		<label class="control-label">简介：</label>
		<textarea name="pexcerpt"><?php echo $places['excerpt']; ?></textarea>
	</div>

	<!-- 特色图片上传 -->


	<div style="float:left; margin-left:30px;">
		<label class="control-label">特色图片：</label>
		<?php
			echo '<img src="' . $places['headimg'] .'" width=300 height=300>';
		?>
		<input type="file" name="file" id="file" />
	</div>
	<!-- 特色图片上传 -->

	<div style="clear: both;"></div>
	<label class="control-label">详细介绍：</label>
	    <script type="text/plain" id="editor" name="myContent">
	    	<?php echo $places['description']; ?>
    	</script>
	<hr>
	<button type="submit" name="submit" class="btn btn-block" >提交</button>
</form>

       
<script type="text/javascript">
	var editor = new UE.ui.Editor();
	textarea:'editor'; //与textarea的name值保持一致
	editor.render('editor');

</script>

<?php
	include_once('footer.php');
?>