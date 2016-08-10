说明：
	使用前先修改根目录config.php中的数据库连接参数,设置完成后进入后台/admin即可使用!
	接口输出数据为XML1.0

调用方法：

1.查询所有城市:	http://localhost/myapi/open/?city=all
	替换域名即可，数据如：
<body>
	<citys>
		<city>
			<id>16</id>
			<name>如来盗</name>
		</city>
	</citys>
</body>

2.查询所有分类：http://localhost/myapi/open/?sort=all
3.查询指定ID景点：http://localhost/myapi/open/?p=1
4.查询某城市所有景点：http://localhost/myapi/open/?city=1
	参数city为城市id,数据如：
<body>
	<citys>
		<city>
			<id>6</id>
			<name>aaaaaaaaaaaaaaaa</name>
			<cityid>15</cityid>
			<description><p>a欢迎使用ueditor!</p></description>
		</city>
	</citys>
</body>

-----------------------

更新日志：
v0.2 (2013.3.4)
	待添加
v0.1 (2013.2)