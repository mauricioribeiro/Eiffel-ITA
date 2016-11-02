<?php 
	class Config {

		private $CONFIG =  array(
			'url' => 'http://161.24.12.204:9090/calc/',
			#'url' => 'http://localhost/calc/',
			'path' => 'C:\\wamp\\www\\calc\\',
			'name' => 'Eiffel',
			'version' => '1.0',
			'client' => 'CEMEF',
			'client_mail_server' => 'sistema@cemef.com.br',
			'page' => '',
			'icon' => 'home',
			'dir' => '/',
			'files-dir' => 'files',
			'root-dir' => null,
			'header-status' => null,
		);

		function __construct(){

			ini_set('session.gc_maxlifetime', 30*60);
			ini_set("safe_mode",0);
			ini_set("register_globals",0);
			ini_set("allow_url_fopen",0);
			ini_set('max_execution_time', "0");
			ini_set('track_errors',1); 
			ini_set('display_errors',1);
			ini_set('file_uploads',1);
			ini_set('upload_max_filesize', "100MB");
			ini_set('post_max_size', "128MB");
			ini_set("session.cookie_lifetime",0);
			
			date_default_timezone_set('America/Sao_Paulo');
			set_time_limit(0);
			error_reporting(1); #E_ALL
			session_cache_limiter(0);
			session_cache_expire(0);
			session_start();

			$this->CONFIG['root-dir'] = $this->getLinkRootDir();
			$this->CONFIG['dir'] = $this->getDir();
		}

		function getConfig($key){
			if(isset($this->CONFIG[$key])) return $this->CONFIG[$key];
			return null;
		}

		function setConfig($key,$val){
			if(in_array($key, array('icon','page','header-status'))){
				$this->CONFIG[$key] = $val;
			}
		}

		function getDir(){
	        $link = str_replace($this->CONFIG['url'],'','http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	        if(strpos($link,'/')) return (strpos($link,'?')) ? substr($link,0,strpos($link,'?')) : $link;
	        return '';
	    }

	    function getLinkRootDir(){
	        //$dir = explode('/',$_SERVER['REQUEST_URI']);
	        $dir = explode('/',$this->CONFIG['url']);
	        return $dir[count($dir)-2];
	    }

	}

 ?>