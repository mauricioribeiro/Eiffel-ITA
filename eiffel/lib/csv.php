<?php

    class CSV extends Config{

        private $baseFolder = null;
        private $fileName = null;
        private $fileExtension = 'csv';
        private $fileData = array();

        function __construct($subFolder){
            $this->baseFolder = $this->getConfig('path').$this->getConfig('files-dir').'/'.$subFolder.'/'.$this->fileExtension.'/';
        }

        function setFileName($file){
            $this->fileName = $file;
            if(!file_exists($this->getFilePath())){
                $this->fileName = null;
            }
        }

        function getFilePath(){
            return $this->baseFolder.$this->fileName.'.'.$this->fileExtension;
        }

        function getData(){
            if(count($this->fileData)){
                return $this->fileData;
            }
            return false;
        }

        function getLine($index){
            if($r = $this->getData()){
                foreach($r as $item) { 
                    if($item['LINE'] == intval($index)) return $item;
                }
            }
            return null;
        }

        function openFile(){
            if($csv = fopen($this->getFilePath(),'r')){
                $labels = false;
                $i = 0;
                while($line = fgetcsv($csv,0,';')){
                    if($labels){
                        array_unshift($line, $i);
                        array_push($this->fileData,array_combine($labels,$line));
                    } else {
                        $labels = $line;
                        array_unshift($labels,'LINE');
                    }
                    $i ++;
                }
                return true;
            }
            return false;
        }

    }

?>