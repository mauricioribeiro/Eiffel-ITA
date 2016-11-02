<?php 

	class File extends Config {

		private $baseFolder = null;
		private $pyFolder = 'py';
		private $csvFolder = 'csv';
		private $jpgFolder = 'jpg';

		function __construct(){
			$this->baseFolder = $this->getConfig('path').$this->getConfig('files-dir');
		}

		function getOptions($subFolder){
			$options = array();
			if($this->checkIn($subFolder)){

				$pyFiles = $this->getFilesFromFolder($this->baseFolder.'/'.$subFolder.'/'.$this->pyFolder);
				$csvFiles = $this->getFilesFromFolder($this->baseFolder.'/'.$subFolder.'/'.$this->csvFolder);
				$jpgFiles = $this->getFilesFromFolder($this->baseFolder.'/'.$subFolder.'/'.$this->jpgFolder);
				
				foreach ($pyFiles as $pyFile) {
					$file = $this->getFileName($pyFile);
					if(in_array($file.'.'.$this->csvFolder, $csvFiles)){ # && in_array($file.'.'.$this->jpgFolder, $jpgFiles)
						array_push($options,$this->file2human($file));
					}
				}
			}
			return $options;
		}

		function getFileName($filePath){
			$f = explode('.',$filePath);
			return $f[0];
		}

		function getFileExtension($filePath){
			$f = explode('.',$filePath);
			return (count($f)==2) ? $f[count($f)-1] : implode('.',array_slice($f,0,-1));
		}

		function getFilesFromFolder($folder){
			return array_slice(scandir($folder),2);
		}

		function checkIn($subFolder){
			if(!file_exists($this->baseFolder.'/'.$subFolder.'/'.$this->pyFolder)) return false;
			if(!file_exists($this->baseFolder.'/'.$subFolder.'/'.$this->csvFolder)) return false;
			if(!file_exists($this->baseFolder.'/'.$subFolder.'/'.$this->jpgFolder)) return false;
			return true;
		}

		function file2human($fileName){
			return ucwords(str_replace('_',' ',$fileName));
		}

		function human2file($humanLabel){
			return strtolower(str_replace(' ','_',$humanLabel));
		}

	}
	
?>