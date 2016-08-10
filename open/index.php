<?php

include_once('../init.php');


if (isset($_GET['city']))	//城市
{
	if ($_GET['city'] == 'all')
        {
		echo_all('city');
	}
        elseif
        (
        	is_numeric($_GET['city']))
        {
		echo_is_num('city');
	}
}
elseif(isset($_GET['sort']))	//类别
{
	if ($_GET['sort'] == 'all')
        {
		echo_all('sort');
	}
        else
        {
		echo_is_num('sort');
	}
}
elseif(isset($_GET['p']))	//景点
{
	echo_p();
}else
{
  	//错误
	echo_error();
}




function echo_error()
{
		echo '
			<!DOCTYPE html>
			<html lang="zh">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<head>
			  <title>myapi - 接口调用错误</title>
			</head>
			<body>

			';
	echo "<h2>错误：请输入正确的格式调用接口！</h2>";
	echo '</body></html>';
}

function echo_p()
{

	//列出景点
	$DB = MySql::getInstance();

	$sql = "SELECT * FROM  places where id=" . $_GET['p'];

	$places = $DB->query($sql);

	header('Content-Type: text/xml;');
	$dom = new DOMDocument('1.0', 'utf-8');
	$body = $dom->createElement('body');
	$dom->appendChild($body);
	$citys = $dom->createElement('citys');
	$body->appendChild($citys);

	while($row = $DB->fetch_array($places)){

		$id = $dom->createElement('id');
		$idText = $dom->createTextNode($row['id']);	//id
		$id->appendChild($idText);

		$name = $dom->createElement('name');
		$nameText = $dom->createTextNode($row['name']);	//name
		$name->appendChild($nameText);
                
                
		$cityid = $dom->createElement('cityid');
		$cityText = $dom->createTextNode($row['cityid']);	//cityid
		$cityid->appendChild($cityText);

		$sortid = $dom->createElement('sortid');
		$sortidText = $dom->createTextNode($row['sortid']);	//cityid
		$sortid->appendChild($sortidText);

		$postion = $dom->createElement('postion');
		$postionText = $dom->createTextNode($row['postion']);	//cityid
		$postion->appendChild($postionText);

		$excerpt = $dom->createElement('excerpt');
		$excerptText = $dom->createTextNode($row['excerpt']);	//cityid
		$excerpt->appendChild($excerptText);
                
		$description = $dom->createElement('description');
		$descriptionText = $dom->createTextNode($row['description']);	//description
		$description->appendChild($descriptionText);
          	
                $headimg = $dom->createElement('headimg');
		$headimgText = $dom->createTextNode($row['headimg']);	//description
		$headimg->appendChild($headimgText);

	
		$city = $dom->createElement('city');
		$city->appendChild($id);
		$city->appendChild($name);
		
                
          
		$city->appendChild($cityid);
		$city->appendChild($sortid);
		$city->appendChild($postion);
                $city->appendChild($excerpt);
		$city->appendChild($description);
		$city->appendChild($headimg);
	

		$citys->appendChild($city);
	}
	
	$xmlString = $dom->saveXML();
	echo $xmlString;

}
function echo_is_num($type)
{
	//列出所有景点
	$DB = MySql::getInstance();

	if ($type=='city') {
		$sql = "SELECT * FROM  places where cityid=" . $_GET['city'];
	}elseif ($type=='sort') {
		$sql = "SELECT * FROM  places where sortid=" . $_GET['sort'];
	}elseif($type=='p'){
		$sql = "SELECT * FROM  places where id=" . $_GET['p'];
	}
	
	$places = $DB->query($sql);

	header('Content-Type: text/xml;');
	$dom = new DOMDocument('1.0', 'utf-8');
	$body = $dom->createElement('body');
	$dom->appendChild($body);
	$citys = $dom->createElement('citys');
	$body->appendChild($citys);

	while($row = $DB->fetch_array($places)){

		$id = $dom->createElement('id');
		$idText = $dom->createTextNode($row['id']);	//id
		$id->appendChild($idText);

		$name = $dom->createElement('name');
		$nameText = $dom->createTextNode($row['name']);	//name
		$name->appendChild($nameText);
                
                
		$excerpt = $dom->createElement('excerpt');
		$excerptText = $dom->createTextNode($row['excerpt']);	//cityid
		$excerpt->appendChild($excerptText);
                
		$postion = $dom->createElement('postion');
		$postionText = $dom->createTextNode($row['postion']);	//cityid
		$postion->appendChild($postionText);

		$headimg = $dom->createElement('headimg');
		$headimgText = $dom->createTextNode($row['headimg']);	//description
		$headimg->appendChild($headimgText);
                
                $sortid = $dom->createElement('sortid');
		$sortidText = $dom->createTextNode($row['sortid']);	//sortid
		$sortid->appendChild($sortidText);
                
          /*
		$cityid = $dom->createElement('cityid');
		$cityText = $dom->createTextNode($row['cityid']);	//cityid
		$cityid->appendChild($cityText);




		$description = $dom->createElement('description');
		$descriptionText = $dom->createTextNode($row['description']);	//description
		$description->appendChild($descriptionText);
          


	*/
		$city = $dom->createElement('city');
		$city->appendChild($id);
		$city->appendChild($sortid);
		$city->appendChild($name);
		$city->appendChild($excerpt);
                $city->appendChild($headimg);
		$city->appendChild($postion);
          /*
		$city->appendChild($cityid);
		$city->appendChild($description);
		
	*/

		$citys->appendChild($city);
	}
	
	$xmlString = $dom->saveXML();
	echo $xmlString;
}

function echo_all($type)
{
	//列出所有城市
	$DB = MySql::getInstance();
	if ($type == 'city') {
		$sql = "SELECT * FROM  city";
	}else{
		$sql = "SELECT * FROM  sort";
	}
	
	$citys_data = $DB->query($sql);

	/*
	用PHP的DOM控件来创建XML输出
	设置输出内容的类型为xml
	*/
	header('Content-Type: text/xml;');

	//创建新的xml文件
	$dom = new DOMDocument('1.0', 'utf-8');

	//建立<body>元素
	$body = $dom->createElement('body');
	$dom->appendChild($body);

	//建立<citys>元素并将其作为<body>的子元素
	$citys = $dom->createElement('citys');
	$body->appendChild($citys);

	while($row = $DB->fetch_array($citys_data)){	//循环添加子项
		
		//为city创建id项
		$id = $dom->createElement('id');
		$idText = $dom->createTextNode($row['id']);	//id
		$id->appendChild($idText);

		//为city创建name元素
		$name = $dom->createElement('name');
		$nameText = $dom->createTextNode($row['name']);	//name
		$name->appendChild($nameText);

		//创建city元素
		$city = $dom->createElement('city');
		$city->appendChild($id);
		$city->appendChild($name);

		//将<city>作为<citys>子元素
		$citys->appendChild($city);
	}
	//在一字符串变量中建立XML结构
	$xmlString = $dom->saveXML();

	//输出XML字符串
	echo $xmlString;

}
?>