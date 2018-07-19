<?php 

// Template_ 2.2.8 2015-12-07 http://www.xtac.net Freeware - LGPL	

class Template_
{
	var $compile_check = true;
	var $compile_dir   = '_compile';
	var $compile_ext   = 'php';
	var $skin          = '';
	var $notice        = false;
	var $path_digest   = false;

	var $template_dir  = '_template';
	var $prefilter     = '';
	var $postfilter    = '';
	var $permission    = 0777;
	var $safe_mode     = false;
	var $auto_constant = false;

	var $caching       = true;
	var $cache_dir     = '_cache';
	var $cache_expire  = 3600;
	
	var $var_=array(''=>array());
	var $obj_=array();
	var $_current_scope ='';
	var $_php_error_reporting;

	function define($arg, $path='')
	{
		
		if (is_array($arg)) 
		{
			foreach ($arg as $fid => $path)
			{
				$this->_define($fid, $path);
			}
		}
		else
		{
			$this->_define($arg, $path);
		}
	}
	function _define($fid, $path)
	{
		switch ($fid[0])
		{
			case '!': $type = 'txt';  $fid = substr($fid,1);  break;
			case '>': $type = 'php';  $fid = substr($fid,1);  break;
			default : $type = 'tpl';
		}

		$this->tpl_[$fid]=array('type'=>$type, 'path'=>$path, 'cache'=>null);
	}

	function assign($arg)
	{
		if (is_array($arg))
		{
			$var = array_merge($var=&$this->var_[$this->_current_scope], $arg);
		}
		else 
		{
			$this->var_[$this->_current_scope][$arg] = func_get_arg(1);
		}
	}
	function fetch($fid)
	{
		ob_start();
		$this->print_($fid);
		$fetch = ob_get_contents();
		ob_end_clean();
		return $fetch;
	}
	function print_($fid, $scope = '', $sub = false)
	{
		if ( ! isset($this->tpl_[$fid]) )
		{
			$this->exit_('Error #2', 'template id <b>'.$fid.'</b> is not defined'); 
		}

		$file_type	= $this->tpl_[$fid]['type'];
		$file_path	= $this->tpl_[$fid]['path'];
		$cache		=&$this->tpl_[$fid]['cache'];


		if ( ! $file_path )
		{
			return;
		}


		if ($file_type === 'txt')
		{
			$this->_print_txt(  $file_path  );
			return;
		}

		if ( $this->_cache_enabled($fid) )
		{
			if ( $this->isCached($fid) )
			{
				echo $cache['content'];
				return;
			}
			ob_start();
		}

		if ($file_type === 'tpl')
		{
			$compile_path = $this->_get_compile_path( $file_path );
			
			if ( isset($this->var_[$fid]) )
			{
				$scope = $fid;
			}

			if ( $sub )
			{
				$this->_include_tpl($compile_path, $fid, $scope);
			}
			else
			{
				$this->_php_error_reporting = error_reporting();
				
				if ($this->notice)
				{
					error_reporting( $this->_php_error_reporting | E_NOTICE );
					set_error_handler('_template_notice_handler');
					$this->_include_tpl($compile_path, $fid, $scope);
					restore_error_handler();
				}
				else
				{
					error_reporting( $this->_php_error_reporting & ~E_NOTICE );
					$this->_include_tpl($compile_path, $fid, $scope);
				}
				error_reporting( $this->_php_error_reporting );
			}
		} 
		else if ($file_type === 'php')
		{

			if ( $sub )
			{
				$_ERROR_REPORTING_IN_PARENT_TPL = error_reporting();
				error_reporting($this->_php_error_reporting);
				if ($this->notice)
				{
					restore_error_handler();
					$this->_include_php( $file_path );
					set_error_handler('_template_notice_handler');
				}
				else
				{
					$this->_include_php( $file_path );
				}
				error_reporting($_ERROR_REPORTING_IN_PARENT_TPL);
			} else {
				$this->_include_php( $file_path );
			}
		}
		
		
		if ( $this->_cache_enabled($fid) )
		{
			$cache_content = ob_get_contents();
			ob_end_flush();
			
			$this->_make_cache_dir($cache['path']);
			
			$fp=fopen($cache['path'], 'wb');
			fwrite($fp, strlen($cache_content).'-'.$cache['header'].'*'.$cache_content);
			fclose($fp);
			chmod($cache['path'], $this->permission&~0111);
			
			if ($cache['remover']) 
			{
				$P1 = $this->cache_dir.'/%clear/';
				$P2 = $this->_path_in_cache_remover($cache['header']);

				
				if (is_array($cache['remover']))
				{
					foreach ($cache['remover'] as $r) 
					{
						$this->_touch_cache_remover($P1.$r.$P2);
					}
				}
				else 
				{
					$this->_touch_cache_remover($P1.$cache['remover'].$P2);
				}

			}
		
		} 
		return;
	}
	function new_($obj)
	{
		$class = 'tpl_object_'.strtolower($obj);
		
		if ( !isset($this->obj_[$class]) )
		{
			if (!class_exists($class, false)) 
			{
				include dirname(__file__).'/tpl_plugin/object.'.$obj.'.php';
			}
			$n = func_num_args();
			if ($n>1) {
				for ($i=1; $i<$n; $i++)
				{
					$arg[$i]=func_get_arg($i);
					$args[]='$arg['.$i.']';
				}
				eval('$this->obj_[$class]=new $class('.implode(',',$args).');');
			} 
			else
			{
				$this->obj_[$class]=new $class;
			}
		}
		return $this->obj_[$class];
	}
	function include_()
	{
		foreach (func_get_args() as $f)
		{
			if ( ! function_exists($f) ) 
			{
				include dirname(__file__).'/tpl_plugin/function.'.$f.'.php';
			}
		}
	}
	function _include_tpl($TPL_CPL, $TPL_TPL, $TPL_SCP)
	{
		$TPL_VAR = &$this->var_[$TPL_SCP];
		
		if (false === include $TPL_CPL) 
		{
			exit;
		}
	}
	function _include_php($file_path)
	{
		if (false === include $file_path)
		{
			exit;
		}
	}
	function _print_txt($file_path)
	{

		$compile_path = $this->_get_compile_path($file_path);

		$fp=fopen($compile_path, 'rb');
		$compile = fread($fp, filesize($compile_path));
		fclose($fp);
		
		echo preg_replace('/^<\?.*?\?>(\r\n|\n|\r)?/s', '', $compile);
		
	}
	function _get_compile_path($rel_path)
	{
		$compile_ext=$this->compile_ext;
		
		if ($R=strpos($rel_path, '?'))
		{
			$compile_ext=substr($rel_path, $R+1).'.'.$compile_ext;
			// $compile_ext contains division id.
			$rel_path=substr($rel_path, 0, $R);
		}

		if (!$this->compile_dir) 
		{
			$this->compile_dir = '.';
		}

		$compile_base = $this->compile_dir.'/'.($this->skin?$this->skin.'/':'').$rel_path;
		// $compile_base is compile path without [ extension and division id ] and passed over to compiler

		if ($this->path_digest)
		{	// enable path_digest to use abs path for $compile_dir and rel path for $template_dir
			$compile_base = $this->compile_dir.'/@digest/'.basename($rel_path).'_'.md5($compile_base);
		}

		$compile_path = $compile_base.'.'.$compile_ext;
		
		if (!$this->compile_check)
		{
			return $compile_path;
		}

		$template_path = $this->template_dir.'/'.($this->skin?$this->skin.'/':'').$rel_path;
		
		if (@!is_file($template_path))
		{
			$this->exit_('Error #1', 'cannot find defined template <b>'.$template_path.'</b>');
		}
		
		$template_path = realpath($template_path);

		$filemtime = @date('Y/m/d H:i:s', filemtime($template_path));
		
		$compile_header = '<?php /* Template_ 2.2.8 '.$filemtime.' '.$template_path.' ';
		
		if ($this->compile_check!=='dev' && @is_file($compile_path)) {
			
			$fp=fopen($compile_path, 'rb');
			$head = fread($fp, strlen($compile_header)+9);
			fclose($fp);

			if (strlen($head)>9
				&& $compile_header == substr($head,0,-9)
				&& filesize($compile_path) == (int)substr($head,-9) ) {
				
				return $compile_path;
			}
		}

		include_once dirname(__file__).'/Template_.compiler.php';
		$compiler=new Template_Compiler_;
		$compiler->_compile_template($this, $template_path, $compile_base, $compile_header);
		
		return $compile_path;
	}
	function setScope($scope='')
	{
		if ( ! isset($this->var_[$scope]) ) 
		{
			$this->var_[$scope]=array();
		}

		$this->_current_scope=$scope;

	}

	function setCache($fid, $expiration=1, $remover='', $multiplier='')
	{
		if ( empty($this->tpl_[$fid])  or  $this->tpl_[$fid]['type']==='txt' )
		{
			$this->exit_('Error #3', 'file id <b>'.$fid.'</b> passed to setCached() is not properly defined');

		}
		else
		{
			if ($expiration < 0) 
			{
				$this->tpl_[$fid]['cache'] = null;
			}
			else
			{
				$this->tpl_[$fid]['cache'] = array(
					'expiration'=> $expiration,
					'remover'	=> $remover,
					'multiplier'=> $multiplier
				);
			}
		}
	}

	function _cache_enabled($fid)
	{
		return  $this->caching  &&  $this->tpl_[$fid]['cache'] &&  $this->compile_check!=='dev' ;
	}

	function isCached($fid)
	{
		if ( ! $this->caching  or  empty($this->tpl_[$fid]['cache'])  or  $this->compile_check==='dev') 
		{
			return false;
		}

		$cache = &$this->tpl_[$fid]['cache'];


		if ( isset($cache['is_cached']) )
		{
			return $cache['is_cached'];
		}


		$cache['header'] = $fid.'/'.$this->skin.'/'.$this->tpl_[$fid]['path'];

		if ($cache['multiplier'])
		{
			$cache['header'] .=  '/'. base64_encode(serialize($cache['multiplier']));
		} 

		$cache['path'] = $this->cache_dir.'/%cache'.$_SERVER['PHP_SELF'].'/'.md5($cache['header']);

		if ( $cache['expiration'] === 1) 
		{
			$cache['expiration'] = $this->cache_expire;
		}

		if ( @!is_file($cache['path']) ) 
		{
			return $cache['is_cached'] = false;
		}


		if ( $cache['expiration']  &&  $cache['expiration']+filemtime($cache['path']) < time() ) 
		{
			return $cache['is_cached'] = false;
		}

		
		if ($cache['remover'])
		{
			$P1 = $this->cache_dir.'/%clear/';
			$P2 = $this->_path_in_cache_remover($cache['header']);

			if (is_array($cache['remover']))
			{
				foreach ($cache['remover'] as $r) 
				{
					if (@ !is_file($P1.$r.$P2)) 
					{
						return $cache['is_cached'] = false;
					}
				}
			} 
			else
			{
				if (@ !is_file($P1.$cache['remover'].$P2)) 
				{
					return $cache['is_cached'] = false;
				}
			}
		}


		$fp=fopen($cache['path'], 'rb');
		$content = fread($fp, filesize($cache['path']));
		fclose($fp);

		if (!$B=strpos($content, '-')  or  !$H=strpos($content, '*'))
		{
			return $cache['is_cached'] = false;
		}
		$length	= intval(substr($content, 0, $B));
		$header = substr($content, $B+1, $H-$B-1);

		$cache['content'] = substr($content, $H+1);

		
		if ($header != $cache['header']  or  strlen($cache['content']) != $length ) 
		{
			return $cache['is_cached'] = false;
		}



		return $cache['is_cached'] = true;
	}
	function clearCache()
	{
		if (!($this->caching && $this->cache_dir && @is_dir($this->cache_dir)))
		{
			return;
		}
		
		if (!func_num_args())
		{
			$this->_empty_out_cache_dir($this->cache_dir);
		}
		else
		{
			foreach (func_get_args() as $dir) 
			{
				$this->_empty_out_cache_dir($this->cache_dir.'/%clear/'.$dir);
			}
		}
	}
	function _empty_out_cache_dir($dir_path)
	{

		if ($this->_shell_exec_available())
		{
			substr(__file__,0,1)==='/'
				? @shell_exec('rm -rf "'.$dir_path.'/"*')
				: @shell_exec('del "'.str_replace('/','\\',$dir_path).'\\*" /s/q');
		}
		else
		{
			$this->_empty_out_recursively($dir_path);
		}
	}
	function _shell_exec_available()
	{
		$blacklist = (string)ini_get("suhosin.executor.func.blacklist") .','. (string)ini_get('disable_functions');

		return (stristr($blacklist, 'shell_exec') || ini_get('safe_mode')) ? false : true;
	}
	function _empty_out_recursively($dir_path, $recursive = 0)
	{
		if (!$d = @dir($dir_path))
		{
			return;
		}

		while ($f = @$d->read()) {
			switch ($f) {
				case '.': case '..': break;
				default : @is_dir($f=$dir_path.'/'.$f) ? $this->_empty_out_recursively($f, 1) : @unlink($f);
			}
		}
		//if ($recursive) @rmdir($path);
		//it's ok not to delete subdirectories. they are just trashes but reused shortly.  shell_exec('del ...') also let them be.
	}
	function _path_in_cache_remover($header)
	{
		$path=urlencode($_SERVER['PHP_SELF'].'?'.$header);
		strlen($path)%80 or $path.='@ff';
		return '/%'.substr(chunk_split($path, 80, '/'), 3, -1);
	}
	function _touch_cache_remover($path)
	{
		if (@is_file($path))
		{
			return;
		}

		$this->_make_cache_dir($path);
		@touch($path);
		@chmod($path, $this->permission&~0111);
	}
	function _make_cache_dir($path)
	{
		if (@is_dir(dirname($path))) 
		{
			return;
		}

		$cache_dir = $this->cache_dir;
		
		if (substr(__file__,0,1) !== '/') {  // windows
			$dir =preg_replace('/\\\\+/', '/', $dir);
			$path=preg_replace('/\\\\+/', '/', $path);
		}

		$dirs=explode('/', substr($path, strlen($cache_dir)+1));

		for ($nodir=0,$i=0,$s=count($dirs)-1; $i<$s; $i++) {
			$cache_dir .= '/'.$dirs[$i];

			if ($nodir or !@is_dir($cache_dir) and $nodir=1) {
				@mkdir($cache_dir, $this->permission);
				@chmod($cache_dir, $this->permission);
			}
		}
	}
	function exit_($type, $msg)
	{
		exit("<br />\n".'<span style="font:12px tahoma,arial;color:#DA0000;background:white">Template_ '.$type.': '.$msg."</span><br />\n");
	}

// About xprint() and xfetch(), refer http://www.xtac.net/bbs/?prc=read&idx=1091
	function xprint($file, $type='tpl') 
	{ 
		$this->define(($type=='txt' ? '!*' : '*'), $file);
		$this->print_('*');
	} 
	function xfetch($file, $type='tpl') 
	{ 
		$this->define(($type=='txt' ? '!*' : '*'), $file);
		return $this->fetch('*'); 
	} 


// Below methods are deprecated.
	function loopLoad($id, $n=1)
	{
		if ($n===1) $this->b1= &$this->var_[$this->_current_scope][$id];
		else $this->{'b'.$n}=&$this->{'b'.--$n}[count($this->{'b'.$n})-1][$id];
	}
	function loopPushAssign($arg, $n=1)
	{
		$this->{'b'.$n}[]=$arg;
	}
	function loopPushLoad($id, $n=2)
	{
		$this->{'b'.$n}=&$this->{'b'.--$n}[][$id];
	}
	function loopAssign($arg, $n=1)
	{
		$section = array_merge($section=&$this->{'b'.$n}[count($this->{'b'.$n})-1], $arg);
	}
	function setLoop($id, $arg, $n=1)
	{
		if ($n===1) $this->var_[$this->_current_scope][$id] = is_array($arg) ? $arg : array_pad(array(), $arg, 1);
		else $this->{'b'.--$n}[count($this->{'b'.$n})-1][$id] = is_array($arg) ? $arg : array_pad(array(), $arg, 1);
	}
	function pushSetLoop($id, $arg, $n=2)
	{
		$this->{'b'.--$n}[][$id] = is_array($arg) ? $arg : array_pad(array(), $arg, 1);
	}
}
function _template_notice_handler($type, $msg, $file, $line)
{
	$msg.=" in <b>$file</b> on line <b>$line</b>";
	switch ($type) {
	case E_NOTICE      :$msg='<span style="font:12px tahoma,arial;color:green;background:white">Template_ Notice #1: '.$msg.'</span>';break;
	case E_WARNING     :
	case E_USER_WARNING:$msg='<b>Warning</b>: '.$msg; break;
	case E_USER_NOTICE :$msg='<b>Notice</b>: ' .$msg; break;
	case E_USER_ERROR  :$msg='<b>Fatal</b>: '  .$msg; break;
	default            :$msg='<b>Unknown</b>: '.$msg; break;
	}
	echo "<br />\n".$msg."<br />\n";
}
?>