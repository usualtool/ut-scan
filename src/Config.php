<?php
$features=[
'后门特征->c99shell'=>'c99shell',
'后门特征->phpspy'=>'phpspy',
'后门特征->Scanners'=>'Scanners',
'后门特征->cmd.php'=>'cmd\.php',
'后门特征->str_rot13'=>'str_rot13',
'后门特征->webshell'=>'webshell',
'后门特征->EgY_SpIdEr'=>'EgY_SpIdEr',
'后门特征->SECFORCE'=>'SECFORCE',
'后门特征->eval("?>'=>'eval\((\'|")\?>',
'复制特征->copy('=>'copy\($_FILES',
'加密特征->eval_r(gzinflate'=>'eval_r\(gzinflate(',
'加密特征->eval_r(base64'=>'eval_r\(base64_decode(',
'可疑代码->system('=>'system\(',
'可疑代码->passthru('=>'passthru\(',
'可疑代码->shell_exec('=>'shell_exec\(',
'可疑代码->exec('=>'exec\(',
'可疑代码->popen('=>'popen\(',
'可疑代码->proc_open'=>'proc_open',
'可疑代码->eval($'=>'eval\((\'|"|\s*)\\$',
'可疑代码->assert($'=>'assert\((\'|"|\s*)\\$',
'危险MYSQL代码->returns string soname'=>'returnsstringsoname',
'危险MYSQL代码->into outfile'=>'intooutfile',
'危险MYSQL代码->load_file'=>'select(\s+)(.*)load_file',
'加密后门->eval(gzinflate('=>'eval\(gzinflate\(',
'加密后门->eval(base64_decode('=>'eval\(base64_decode\(',
'加密后门->eval(gzuncompress('=>'eval\(gzuncompress\(',
'加密后门->eval(gzdecode('=>'eval\(gzdecode\(',
'加密后门->eval(str_rot13('=>'eval\(str_rot13\(',
'加密后门->gzuncompress(base64_decode('=>'gzuncompress\(base64_decode\(',
'加密后门->base64_decode(gzuncompress('=>'base64_decode\(gzuncompress\(',
'一句话后门->eval_r('=>'eval_r\(',
'一句话后门->eval($_'=>'eval\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)',
'一句话后门->assert($_'=>'assert\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)',
'一句话后门->require($_'=>'require\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)',
'一句话后门->require_once($_'=>'require_once\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)',
'一句话后门->include($_'=>'include\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)',
'一句话后门->include_once($_'=>'include_once\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)', 
'一句话后门->call_user_func("assert"'=>'call_user_func\(("|\')assert("|\')',  
'一句话后门->call_user_func($_'=>'call_user_func\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)',
'一句话后门->$_POST/GET/REQUEST/COOKIE[?]($_POST/GET/REQUEST/COOKIE[?]'=>'\$_(POST|GET|REQUEST|COOKIE)\[([^\]]+)\]\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)\[', 
'一句话后门->echo(file_get_contents($_POST/GET/REQUEST/COOKIE'=>'echo\(file_get_contents\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)',
'上传后门->file_put_contents($_POST/GET/REQUEST/COOKIE,$_POST/GET/REQUEST/COOKIE'=>'file_put_contents\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)\[([^\]]+)\],(\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)',
'上传后门->fputs(fopen("?","w"),$_POST/GET/REQUEST/COOKIE['=>'fputs\(fopen\((.+),(\'|")w(\'|")\),(\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)\[',
'.htaccess插马->SetHandler application/x-httpd-php'=>'SetHandlerapplication\/x-httpd-php',
'.htaccess插马->php_value auto_prepend_file'=>'php_valueauto_prepend_file',
'.htaccess插马->php_value auto_append_file'=>'php_valueauto_append_file'
];