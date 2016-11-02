<?php

class util
{

    function printMsg($msg){
        if(!is_null($msg)){
            if(isset($msg[2])) $msg[1] .= ' <a href="'.$msg[2].'">Atualize página</a> para que as modificações sejam feitas.';
            echo '<div class="alert alert-'.$msg[0].' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$msg[1].'</div>';
        }
    }

    function printLastButtons($btn_del = array('config_url'=>null,'id'=>null,'text'=>null)){
        $r = '<div class="form-group">
            <div class="col-sm-12">
              <button class="btn btn-success pull-right">Salvar</button>
              <a href="#" onclick="window.history.back();" class="btn btn-default pull-right">Voltar</a>';
      if(!is_null($btn_del['id'])) $r .= $this->printButtonDel($btn_del['config_url'],$btn_del['id'],$btn_del['text']);
      $r .= '</div></div>';
      return $r;
    }

    function printButtonDel($config_url,$id,$text=null){
        $t = (is_null($text)) ? 'Deletar Item' : $text;
        return '<!--<div class="form-group">
                <div class="col-sm-12">-->
                  <a class="btn btn-danger btn-del pull-right" data-url="'.$config_url.'/del.php?ID='.$this->Criptografar($id).'" data-toggle="modal" data-target="#mdlDeleteItem">'.$t.'</a>
                <!--</div>
              </div>-->';
    }

    function getLinkURL($config_url){
        $link = str_replace($config_url,'','http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        if(strpos($link,'/')) return (strpos($link,'?')) ? substr($link,0,strpos($link,'?')) : $link;
        return '';
    }

    function getLinkRootDir($config_url){
        $dir = explode('/',$_SERVER['REQUEST_URI']);
        return $dir[count($dir)-2];
    }

    function printButtonInfo($id_name){
        return '<a href="javascript:void(0);" class="btn btn-info btn-xs show-info" data-id-content="'.$id_name.'" data-toggle="modal" data-target="#mdlInfo"><i class="fa fa-eye"></i></a>';
    }

    function getIP(){
        if (getenv('HTTP_CLIENT_IP'))
            $ip = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ip = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ip = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ip = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ip = getenv('REMOTE_ADDR');
        else $ip = 'UNKNOWN';
        return $ip;
    }

    function isthereFile($f){
        return (isset($f['size']) && intval($f['size'])!=0) ? true : false;
    }

    function money2float($cash){
        return floatval(str_replace(',','.', str_replace('.','', $cash)));
    }

    function float2money($f){
        /*$cash = explode('.',strval($f));
        if(count($cash)>1){
            $r = number_format($cash[0],0,',','.').',';
            return (strlen($cash[1])!=1) ? $r.$cash[1] : $r.$cash[1].'0';
        } else {
            return str_replace('.',',',strval($f)).',00';
        }*/
        return number_format($f, 2, ',', '.');
    }

    function getDaysFromDates($date_a,$date_b,$delimiter = '/',$isamerican = true){
        $da_array = split($delimiter,$date_a);
        $db_array = split($delimiter,$date_b);
        $da = ($isamerican) ? new DateTime($da_array[2].'-'.$da_array[1].'-'.$da_array[0]) : new DateTime($da_array[2].'-'.$da_array[0].'-'.$da_array[1]);
        $db = ($isamerican) ? new DateTime($db_array[2].'-'.$db_array[1].'-'.$db_array[0]) : new DateTime($db_array[2].'-'.$db_array[0].'-'.$db_array[1]);

        return round(abs($db->format('U') - $da->format('U'))/(60*60*24));
        # return $da->diff($db); PHP 5.3+
    }

    # green to red / ok to critical
    function getColor($level){
        while($level>=5){
            $level -= 5;
        }
        $c = array('00E50E','00C7D9','1400CE','C300AC','B81800');
        return '#'.$c[$level];
    }

    
    function getMatrixPrevisao(){
        $r =  array();
        for ($mes=1; $mes <= 12; $mes++) {
            $r[$mes]['item'] = 0;
            $r[$mes]['prefixarray'] = array();
            $r[$mes]['objarray'] = array();
        }
        return $r;
    }

    function getLinkFromMatrixPrevisao($m,$title = '',$class = 'box-list',$boletim = false){
        foreach($m as $k => $data) {
            $m[$k]['link'] = ($data['item']) ? '<a href="javascript:void(0)" class="'.$class.'" data-toggle="modal" data-target="#mdlInfo" data-obj="'.implode(',',$data['objarray']).'" data-prefix="'.implode(',',$data['prefixarray']).'" title="'.$title.'">'.$this->float2money($data['item']).'</a>' : '---';
            unset($m[$k]['objarray'],$m[$k]['prefixarray']);
        }
        return $m;
    }

    function getHtml($url, $post = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        if(!empty($post)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        } 
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}

?>