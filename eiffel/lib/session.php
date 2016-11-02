<?php 
	
	class Session extends Config {

		function reset(){
			session_destroy();
			session_start();
		}

		function refresh($key,$value){
			$_SESSION[$key] = $value;
		}

		function get($key){
			return ($this->has($key)) ? $_SESSION[$key] : null;
		}

		function has($key){
			return (isset($_SESSION[$key])) ? true : false;
		}

		function isTrue($key){
			return ($this->has($key) && $_SESSION[$key]) ? true : false;
		}

		function toArray(){
			$r = array();
			if(isset($_SESSION)){
				foreach ($_SESSION as $k => $v) {
					$r[$k] = $v;
				}
			}
			return $r;
		}

		function toJson(){
			$r = $this->toArray();
			return json_encode($r);
		}

	}

 ?>