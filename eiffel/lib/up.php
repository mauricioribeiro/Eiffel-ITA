<?php

/**
 * Essa é a classe utilizada para uploads de imagem
 

 * @access public
 */
class up{

    /**
     * Array com as opções do Plugin
     *  
     * @access public 
     * @var array
     */
    var $Opcoes = array(
            'auto' => 'false',
            'multi' => 'false',
            'buttonText' => 'Selecionar Arquivos',
            'fileObjName' => 'fileArquivos',
            'fileTypeExts' => '*.pdf; *.doc; *.xls',
        );

    /**
     * Variável recebe o nome do arquivo
     *  
     * @access public 
     * @var string
     */
    var $NomeArquivo;

        /**
     * Variável recebe os tipos aceitaveis de arquivo
     *  
     * @access public 
     * @var string
     */
    var $Tipos = array('jpg','jpeg','gif','png');

    /**
     * Variável recebe o divisor, no caso de arquivos multiplos
     *  
     * @access public 
     * @var string
     */
    var $Divisor = ',';

    /**
     * Variável recebe a URL da Pasta onde sera salvo o arquivo. (partindo do base do site)
     *  
     * @access public 
     * @var string
     */
    var $Pasta;

        /**
     * Função que formata o nome do arquivo
     * 
     * @param string $str
     * @access public 
     * @return string
     */
    function Formatar($str)
    {
         $str_final = strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
         return str_replace(' ', '_', $str_final);
    }


    /**
     * Função que faz upload dos arquivos
     * 
     * @access public
     * @return string
     */
    function Enviar($arquivos){

        if(!is_dir($this->Pasta)){
            mkdir($this->Pasta);
        }

        $this->NomeArquivo = "";

        if (!empty($arquivos)) {
            $CaminhoTemporario = $arquivos['tmp_name'];
            $CaminhoFinal = $this->Pasta . $this->Formatar($arquivos['name']);
            
            // Validate the file type
            $extensoes = $this->Tipos; // File extensions
            $fileParts = pathinfo($arquivos['name']);
            
            if (in_array($fileParts['extension'],$extensoes)) {
                move_uploaded_file($CaminhoTemporario,$CaminhoFinal);
                $this->NomeArquivo .=  $this->Formatar($arquivos['name']);
                $this->NomeArquivo;
                if($this->Opcoes['multi']=='true'){
                    $this->NomeArquivo .= $this->Divisor;
                }
            } else {
                echo 'Arquivo Invalido';
            }
        }

    }


    /**
     * Função que faz upload dos arquivos
     * 
     * @access public
     * @return string
    */
    function Remove($arquivos, $excluido){

        $arquivos = explode(",", $arquivos);

        $restantes = "";

        for($i=0; $i < count($arquivos); $i++) {
            if($excluido==$arquivos[$i]){
                unlink($this->Pasta.$excluido);
            } else{
                $restantes .= ($restantes) ? ',' . $arquivos[$i] : $arquivos[$i];
            }
        }   

        return $restantes;
    }
}
?>