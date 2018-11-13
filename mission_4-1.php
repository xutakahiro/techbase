<?php
header("Content-Type: text/html;charset=UTF-8");
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);
if(isset($_POST['delete'])){
	if(empty($_POST['dpass'])||empty($_POST['dnumber'])){
		echo "入力が不十分です"."<br/>";
	}
	if(!empty($_POST['dnumber'])&&!empty($_POST['dpass'])){
		$sq='SELECT*FROM board2';
		$flag=0;
		$results=$pdo->query($sq);
		$id=$_POST['dnumber'];
		foreach($results as $row){
			if($row['id']==$id&&$row['pass']!=$_POST['dpass']){
				echo "パスワードが違います"."<br/>";
				break;
			}
		}
	}
}
if(isset($_POST['edit'])){
	if(empty($_POST['epass'])||empty($_POST['enumber'])){
		echo "入力が不十分です"."<br/>";
	}
	if(!empty($_POST['enumber'])&&!empty($_POST['epass'])){
		$flag=0;
		$sq='SELECT*FROM board2';
		$results=$pdo->query($sq);
		$id=$_POST['enumber'];
		foreach($results as $row){
			if($row['id']==$id&&$row['pass']==$_POST['epass']){
				$enum=$row['id'];
				$ename=$row['name'];
				$ecomment=$row['comment'];
				$flag=1;
				break;
			}
		}
		if($flag==0){
			echo "パスワードが違います"."\n";
		}
	}
}	

?>

<!DOCTYPE html>
<html lang = "ja">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<body>
<form method = "post" action = "mission_4-1.php">
<input type = "text" name = "name"  value="<?php echo $ename;?>" placeholder="名前" size="20"> <br/>
<input type = "text" name = "message" value="<?php echo  $ecomment;?>" placeholder="コメント" size="20"> <br/>
<input type = "hidden" name = "enum" value="<?php echo $enum;?>">
<input type = "text" name = "pass" placeholder="パスワード" size="20">
<input type = "submit" name = "submit" value = "送信"><br/><br/>
<input type = "text" name = "dnumber" placeholder="削除番号" size="20"><br/>
<input type = "text" name = "dpass" placeholder="パスワード" size="20">
<input type = "submit" name = "delete" value = "削除"><br/>
<input type = "text" name = "enumber" placeholder="編集番号" size="20"><br/>
<input type = "text" name = "epass" placeholder="パスワード" size="20">
<input type = "submit" name = "edit" value = "編集"><br/>

</form>
</body>
</html>
<hr>

<?php
header("Content-Type: text/html;charset=UTF-8");
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);
$sql="CREATE TABLE board2"
."("
."id INT,"
."name char(32),"
."comment TEXT,"
."time TEXT,"
."pass TEXT"
.");";
$stmt=$pdo->query($sql);
if(isset($_POST['submit'])){
	if(!empty($_POST['message'])&&!empty($_POST['name'])&&empty($_POST['enum'])&&!empty($_POST['pass'])){
		$sl='SELECT*FROM board2';
		$results=$pdo->query($sl);
		$c=count($results);
		foreach($results as $row){
			
			//$idd=$row['id'].' ';
			$idd=$row['id'];
			//echo $idd.' '.$max.'<br/>';
			if($idd>=$max){
				$max=$idd;
			}
		}
		

		
		$sql=$pdo->prepare("INSERT INTO board2(id,name,comment,time,pass) VALUES(:id,:name,:comment,:time,:pass)");
		$sql->bindParam(':id',$id,PDO::PARAM_STR);
		$sql->bindParam(':name',$name,PDO::PARAM_STR);
		$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
		$sql->bindParam(':time',$time,PDO::PARAM_STR);
		$sql->bindParam(':pass',$pass,PDO::PARAM_STR);
		$id=$max+1;
		//echo $idd.' '.$max.' '.$id.'<br/>';
		$name=$_POST['name'];
		$comment=$_POST['message'];
		$time=date("Y/m/d H:i:s");
		//echo $time.'<br/>';
		$pass=$_POST['pass'];
		
		$sql->execute();
		
		
	}
	if(!empty($_POST['message'])&&!empty($_POST['name'])&&!empty($_POST['enum'])){
		if(empty($_POST['pass'])){
			echo "パスワードを入力してください"."<br/>";
		}
		else{
			$id=intval($_POST['enum']);
			$name=$_POST['name'];
			$comment=$_POST['message'];
			$time=date("Y/m/d H:i:s");
			$pass=$_POST['pass'];
			//echo $id.' '.$name.' '.$comment.' '.$pass.'<br/>';
		
			$sql1="UPDATE board2 SET name='$name', comment='$comment', time='$time', pass='$pass' where id=$id";
			$results=$pdo->query($sql1);
		
		}
		/*$sq='SELECT*FROM board2';<input type = "submit" name = "alld" value = "全削除"><br/>
		$results=$pdo->query($sq);
		foreach($results as $row){
			echo $row['id'].' ';
			echo $row['name'].' ';
			echo $row['comment'].' ';
			echo $row['time'].'<br>';
		}*/
	}
	$sq='SELECT*FROM board2';
	$results=$pdo->query($sq);
	foreach($results as $row){
		echo $row['id'].' ';
		echo $row['name'].' ';
		echo $row['comment'].' ';
		echo $row['time'].'<br>';
	}
	
}
if(isset($_POST['delete'])){
	if(!empty($_POST['dnumber'])&&!empty($_POST['dpass'])){
		$sq='SELECT*FROM board2';
		$flag=0;
		$results=$pdo->query($sq);
		$id=$_POST['dnumber'];
		foreach($results as $row){
			if($row['id']==$id&&$row['pass']==$_POST['dpass']){
				$sql="DELETE from board2 where id=$id";
				$results=$pdo->query($sql);
				break;
			}
		}
		//echo $flag.'<br/>';
		
		
	}
	$sq='SELECT*FROM board2';
	$results=$pdo->query($sq);
	foreach($results as $row){
		echo $row['id'].' ';
		echo $row['name'].' ';
		echo $row['comment'].' ';
		echo $row['time'].'<br>';
	
	}
}
if(isset($_POST['edit'])){
	$sq='SELECT*FROM board2';
	$results=$pdo->query($sq);
	foreach($results as $row){
		echo $row['id'].' ';
		echo $row['name'].' ';
		echo $row['comment'].' ';
		echo $row['time'].'<br>';
	
	}
}
/*if(isset($_POST['alld'])){
	$sql="DELETE from board2";
	$results=$pdo->query($sql);
	$sq='SELECT*FROM board2';
	$results=$pdo->query($sq);
	foreach($results as $row){
		echo $row['id'].' ';
		echo $row['name'].' ';
		echo $row['comment'].' ';
		echo $row['time'].'<br>';
	
	}
}*/

?>

