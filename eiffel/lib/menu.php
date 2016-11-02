<?php

    class Menu{

        private $items = array();

        function __construct(){
            $this->addItem('Verificação','design.png','verificacao');
            $this->addItem('Solicitação','gravity.png','solicitacao');
            $this->addItem('Resistência','stone.png','resistencia');
            $this->addItem('Relatório','report.png','relatorio');
            $this->addItem('Ajuda','question.png','ajuda');
        }

        function addItem($name,$icon,$link = '',$parent = null){
            array_push(
                $this->items,
                array(
                    'id' => $this->getNextId(),
                    'name' => $name,
                    'icon' => $icon,
                    'link' => $link,
                    'parent' => $parent
                )
            );
        }

        function getItems(){
            return $this->items;
        }

        function getNextId(){
            return count($this->getItems()) + 1;
        }

        function getItem($index,$key = null){
            return (is_null($key)) ? $this->items[$index] : $this->items[$index][$key];
        }

        function getParents(){
            $r = array();
            foreach($this->getItems() as $item){
                if(is_null($item['parent'])) array_push($r,$item);
            }
            return $r;
        }

        function getChildren($parentId){
            $r = array();
            foreach($this->getItems() as $item){
                if($item['parent'] == $parentId) array_push($r,$item);
            }
            return $r;
        }

        function countItems($parent = null){
            if(!is_null($parent)){
                $n = 0;
                foreach($this->getItems() as $item){
                    if($parent && !is_null($item['parent'])) $n++;
                    if(!$parent && is_null($item['parent'])) $n++;
                }
                return $n;
            }
            return count($this->items);
        }

    }
?>