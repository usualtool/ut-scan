<?php
namespace usualtool\Scan;
class Scan{
	public function __construct(){
		$this->count=0;
		$this->scanned=0;
		$this->list=array();
	    $this->features=[
		'Back door->c99shell'=>'c99shell',
		'Back door->phpspy'=>'phpspy',
		'Back door->Scanners'=>'Scanners',
		'Back door->cmd.php'=>'cmd\.php',
		'Back door->str_rot13'=>'str_rot13',
		'Back door->webshell'=>'webshell',
		'Back door->EgY_SpIdEr'=>'EgY_SpIdEr',
		'Back door->SECFORCE'=>'SECFORCE',
		'Hazard function->eval("?>'=>'eval\((\'|")\?>',
		'Hazard function->copy('=>'copy\($_FILES',
		'Hazard function->eval_r(gzinflate'=>'eval_r\(gzinflate(',
		'Hazard function->eval_r(base64'=>'eval_r\(base64_decode(',
		'Hazard function->system('=>'system\(',
		'Hazard function->passthru('=>'passthru\(',
		'Hazard function->shell_exec('=>'shell_exec\(',
		'Hazard function->exec('=>'exec\(',
		'Hazard function->popen('=>'popen\(',
		'Hazard function->proc_open'=>'proc_open',
		'Hazard function->eval($'=>'eval\((\'|"|\s*)\\$',
		'Hazard function->assert($'=>'assert\((\'|"|\s*)\\$',
		'Hazard code->returns string soname'=>'returnsstringsoname',
		'Hazard code->into outfile'=>'intooutfile',
		'Hazard code->load_file'=>'select(\s+)(.*)load_file',
		'Encrypted door->eval(gzinflate('=>'eval\(gzinflate\(',
		'Encrypted door->eval(base64_decode('=>'eval\(base64_decode\(',
		'Encrypted door->eval(gzuncompress('=>'eval\(gzuncompress\(',
		'Encrypted door->eval(gzdecode('=>'eval\(gzdecode\(',
		'Encrypted door->eval(str_rot13('=>'eval\(str_rot13\(',
		'Encrypted door->gzuncompress(base64_decode('=>'gzuncompress\(base64_decode\(',
		'Encrypted door->base64_decode(gzuncompress('=>'base64_decode\(gzuncompress\(',
		'A sentence->eval_r('=>'eval_r\(',
		'A sentence->eval($_'=>'eval\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)',
		'A sentence->assert($_'=>'assert\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)',
		'A sentence->require($_'=>'require\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)',
		'A sentence->require_once($_'=>'require_once\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)',
		'A sentence->include($_'=>'include\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)',
		'A sentence->include_once($_'=>'include_once\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)', 
		'A sentence->call_user_func("assert"'=>'call_user_func\(("|\')assert("|\')',  
		'A sentence->call_user_func($_'=>'call_user_func\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)',
		'A sentence->$_POST/GET/REQUEST/COOKIE[?]($_POST/GET/REQUEST/COOKIE[?]'=>'\$_(POST|GET|REQUEST|COOKIE)\[([^\]]+)\]\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)\[', 
		'A sentence->echo(file_get_contents($_POST/GET/REQUEST/COOKIE'=>'echo\(file_get_contents\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)',
		'Upload door->file_put_contents($_POST/GET/REQUEST/COOKIE,$_POST/GET/REQUEST/COOKIE'=>'file_put_contents\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)\[([^\]]+)\],(\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)',
		'Upload door->fputs(fopen("?","w"),$_POST/GET/REQUEST/COOKIE['=>'fputs\(fopen\((.+),(\'|")w(\'|")\),(\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)\[',
		'Htaccess horse->SetHandler application/x-httpd-php'=>'SetHandlerapplication\/x-httpd-php',
		'Htaccess horse->php_value auto_prepend_file'=>'php_valueauto_prepend_file',
		'Htaccess horse->php_value auto_append_file'=>'php_valueauto_append_file'
		];
	}	
    public function Scan($path=UTF_ROOT,$is_ext='php'){
        $ignore = array('.', '..' );
        $replace=array(" ","\n","\r","\t");
        $dh = @opendir($path);
        while(false!==($file=readdir($dh))){
            if(!in_array($file,$ignore)){                 
                if(is_dir($path."/".$file)){
                $this->Scan($path."/".$file."/",$is_ext);            
                }else{
                    $current = $path.$file;
					$current = str_replace("//","/",$current);
                    if(!preg_match("/$is_ext/i",$file)) continue;
                    if(is_readable($current) && strpos($current,'usualtool/ut-scan')===false && strpos($current,'library/UsualTool')===false){
                        $this->scanned++;
                        $content=file_get_contents($current);
                        $content= str_replace($replace,"",$content);
                        foreach($this->features as $key => $value){
                            if(preg_match("/$value/i",$content)){
                                $this->count++;
                                $j = $this->count % 2 + 1;
                                $filetime = date('Y-m-d H:i:s',filemtime($current));
                                $reason = explode("->",$key);
                                preg_match("/$value/i",$content,$arr);
								$this->list[]=array(
									"id"=>$this->count,
									"path"=>$current,
									"filetime"=>$filetime,
									"reason"=>$reason[0],
									"code"=>$reason[1]
								);
                                break;
                            }
                        }
                    }
                }
            }
		}
        closedir($dh);
		return $this->list;
    }
}
