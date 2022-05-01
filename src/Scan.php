<?php
ob_start();
set_time_limit(0);
$realpath=realpath('./');
$selfpath=$_SERVER['PHP_SELF'];
$selfpath=substr($selfpath, 0, strrpos($selfpath,'/'));
define('REALPATH', str_replace('//','/',str_replace('\\','/',substr($realpath, 0, strlen($realpath) - strlen($selfpath)))));
define('MYFILE', basename(__FILE__));
define('ROOTPATH', str_replace('\\', '/', dirname(dirname(__FILE__))).'/');
define('MYPATH', str_replace('\\', '/', dirname(__FILE__)).'/');
define('MYFULLPATH', str_replace('\\', '/', (__FILE__)));
define('HOST', "http://".$_SERVER['HTTP_HOST']);
$setting = getSetting();
$action = isset($_GET['action'])?$_GET['action']:"";
if($action=="download" && isset($_GET['file']) && trim($_GET['file'])!=""){
$file = $_GET['file'];
ob_clean();
if (@file_exists($file)) {
header("Content-type: application/octet-stream");
header("Content-Disposition: filename=\"".basename($file)."\"");
echo file_get_contents($file);
}
exit();
}
?>
<style>
.alt1 td{border-top:1px solid #fff;border-bottom:1px solid #ddd;background:#f1f1f1;height:30px;}
.alt2 td{border-top:1px solid #fff;border-bottom:1px solid #ddd;background:#f9f9f9;height:30px;}
.focus td{border-top:1px solid #fff;border-bottom:1px solid #ddd;background:#ffffaa;height:30px;}
.head td{border-top:1px solid #fff;border-bottom:1px solid #ddd;background:#e9e9e9;height:30px;font-weight:bold;}
.head td span{font-weight:normal;}
</style>
<?php
if($action=="set"){
if(isset($_POST['btnset'])){
$utttsets = array();
$utttsets['user']=isset($_POST['checkuser'])?$_POST['checkuser']:"php | cms | html | shtml";
$utttsets['all']=isset($_POST['checkall'])&&$_POST['checkall']=="on"?1:0;
$utttsets['hta']=isset($_POST['checkhta'])&&$_POST['checkhta']=="on"?1:0;
setcookie("utttset", base64_encode(serialize($utttsets)), time()+60*60*24*365,"/");
echo "<script>alert('扫描参数设置成功!');window.location.href='?hookid=usualtooltt&action=scan'</script>";
exit();
}
?>
<form name="set" method="post" action="?hookid=usualtooltt&action=set">
<fieldset style="width:400px">
<LEGEND>扫描设置</LEGEND>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	    <td width="60">文件后缀:</td>
	    <td width="300"><input type="text" name="checkuser" id="checkuser" style="border:1px solid #eee;width:300px;" value="<?php echo $setting['user']?>"></td>
	</tr>
	<tr>
	    <td><label for="checkall">所有文件</label></td>
	    <td><input type="checkbox" name="checkall" id="checkall" <?php if($setting['all']==1) echo "checked"?>></td>
	</tr>
	<tr>
	    <td><label for="checkhta">设置文件</label></td>
	    <td><input type="checkbox" name="checkhta" id="checkhta" <?php if($setting['hta']==1) echo "checked"?>></td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td>
	    <input type="submit" name="btnset" id="btnset" value="提交" style="width:50px;height:30px;background-color:green;color:white;">
	    </td>
	</tr>
</table>
</fieldset>
</form>
<?php
}else{
$dir = isset($_POST['path'])?$_POST['path']:ROOTPATH;
$dir = substr($dir,-1)!="/"?$dir."/":$dir;
?>
<form name="scan" method="post" action="?hookid=usualtooltt">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>扫描路径：
		<input type="text" name="path" id="path" style="width:40%;height:30px;border:1px solid #eee;" value="<?php echo $dir?>">
		&nbsp;&nbsp;
		<input type="submit" name="btnscan" id="btnscan" value="开始扫描" style="width:100px;height:30px;background-color:green;color:white;">
		&nbsp;&nbsp;
		<a href="?hookid=usualtooltt&action=scan">初筛扫描</a> | 
		<a href="?hookid=usualtooltt&action=set">扫描设置</a>
		</td>
	</tr>
</table>
</form>
<?php
if(isset($_POST['btnscan'])){
$start=time();
$is_user = array();
$is_ext = "";
$list = "";
if(trim($setting['user'])!=""){
$is_user = explode("|",$setting['user']);
if(count($is_user)>0){
foreach($is_user as $key=>$value)
$is_user[$key]=trim(str_replace("?","(.)",$value));
$is_ext = "(\.".implode("($|\.))|(\.",$is_user)."($|\.))";
}
}
if($setting['hta']==1){
$is_hta=1;
$is_ext = strlen($is_ext)>0?$is_ext."|":$is_ext;
$is_ext.="(^\.htaccess$)";
}
if($setting['all']==1 || (strlen($is_ext)==0 && $setting['hta']==0)){
$is_ext="(.+)";
}
$php_code = json_decode(UsualToolCMS::Auth($authcode,$authapiurl,"usualtooltt"),TRUE);
if(!is_readable($dir))
$dir = MYPATH;
$count=$scanned=0;
scan($dir,$is_ext);
$end=time();
$spent = ($end - $start);
?>
<div style="margin:10px 0;padding:10px; background-color:#ccc">已扫描: <?php echo $scanned?> 文件 | 发现: <?php echo $count?> 可疑文件 | 耗时: <?php echo $spent?> 秒</div>
<div id="ut-auto">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr class="head">
	<td width="15">No.</td>
	<td width="40%">文件</td>
	<td width="20%">更新时间</td>
	<td width="15%">原因</td>
	<td width="20%">特征</td>
	</tr>
<?php echo$list;?>
</table>
<?php
}
}
ob_flush();
?>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="40">
<tr><td>官网同步更新后门及木马库版本:1.1.181020</td></tr>
</table>
<?php
function scan($path = '.',$is_ext){
global $php_code,$count,$scanned,$list;
$ignore = array('.', '..' );
$replace=array(" ","\n","\r","\t");
$dh = @opendir( $path );
while(false!==($file=readdir($dh))){
if( !in_array( $file, $ignore ) ){                 
if( is_dir( "$path$file" ) ){
scan("$path$file/",$is_ext);            
}else{
$current = $path.$file;
if(MYFULLPATH==$current) continue;
if(!preg_match("/$is_ext/i",$file)) continue;
if(is_readable($current)){
$scanned++;
$content=file_get_contents($current);
$content= str_replace($replace,"",$content);
foreach($php_code as $key => $value){
if(preg_match("/$value/i",$content)){
$count++;
$j = $count % 2 + 1;
$filetime = date('Y-m-d H:i:s',filemtime($current));
$reason = explode("->",$key);
$url =  str_replace(REALPATH,HOST,$current);
preg_match("/$value/i",$content,$arr);
$list.="
<tr class='alt$j' onmouseover='this.className=\"focus\";' onmouseout='this.className=\"alt$j\";'>
<td>$count</td>
<td><a href='$url' target='_blank'>$current</a></td>
<td>$filetime</td>
<td><font color=red>$reason[0]</font></td>
<td><font color=#090>$reason[1]</font></td>
</tr>";
break;
}
}
}
}
}
}
closedir( $dh );
}
function getSetting(){
$utttsets = array();
if(isset($_COOKIE['utttset'])){
$utttsets = unserialize(base64_decode($_COOKIE['utttset']));
$utttsets['user']=isset($utttsets['user'])?$utttsets['user']:"php | cms | html | shtml";
$utttsets['all']=isset($utttsets['all'])?intval($utttsets['all']):0;
$utttsets['hta']=isset($utttsets['hta'])?intval($utttsets['hta']):1;
}else{
$utttsets['user']="php | cms | html | shtml";
$utttsets['all']=0;
$utttsets['hta']=1;
setcookie("utttset", base64_encode(serialize($utttsets)), time()+60*60*24*365,"/");
}
return $utttsets;
}
?>
