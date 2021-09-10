#!/usr/bin/env php

<?php

if ($argc == 2) {
  if ($argv[1] == '-h') {
    echo "Options:
          -i: Initials (MP, DPE, TJTO, TRF4 etc) Opcional
          -n: Name - Obrigatorio
          -x: Extends Class - (Ex: class ProcessoMPDTO extends ProcessoDTO)
          -h: Help
  ".PHP_EOL;

  echo "Exemplo de uso:".PHP_EOL;
  echo "./eprocli.php -i MP -n Processo -x Processo";
  }
}

$options = array('-i','-n', '-x');
$dirs = array('dto','rn', 'int', 'bd');
$flags = false; //FILE_APPEND;

// var_dump(count(array_diff($argv, $options))-1) or die();


if (count(array_diff($argv, $options))-1 > (($argc-1)/2)) {
  echo "Verifique os parâmetros e tente novamente".PHP_EOL;
  echo "Options:
          -i: Initials (MP, DPE, TJTO, TRF4 etc) Opcional
          -n: Name - Obrigatorio
          -x: Extends Class - (Ex: class ProcessoMPDTO extends ProcessoDTO)
          -h: Help
  ".PHP_EOL;
  die();
}


if ($argc == 1) {
  echo "Faltam de parâmetros!".PHP_EOL;
  die();
}

if ($argc == 2) {
  echo "Falta de parâmetros!".PHP_EOL."Verifique a presença do identificador '-n' ou o seu valor, caso o identificador esteja presente.".PHP_EOL;
  die();
}

if ($argc == 4) {
  echo "Falta de parâmetros!".PHP_EOL."Verifique a presença do identificador '-n' ou '-i' ou os seus valores respectivos e os espaços entre eles, caso os identificadores estejam presentes.".PHP_EOL;
  die();
}

if ($argc == 6) {
  echo "Falta de parâmetros!".PHP_EOL."Verifique a presença do identificador '-n', '-i' e '-x' ou os seus valores respectivos e os espaços entre eles, caso os identificadores estejam presentes.".PHP_EOL;
  die();
}

if ($argc > 7) {
  echo "Excesso de parâmetros!".PHP_EOL;
  die();
} 

if ($argv[1] == '-i' && $argc == 3) {
  echo "O parâmentro de nome do arquivo é obrigatório.".PHP_EOL;
  die();
}

if (!in_array($argv[1], $options) ) {
  echo "Identiicador do primeiro argumento inválido".PHP_EOL;
  die();
}

if ($argc > 3) {
  if (!in_array($argv[3], $options)) {
    echo "Identificador do segundo argumento inválido".PHP_EOL;
    die();
  }
}

$tag_index = array_search('-n', $argv);
if ($argv[$tag_index] == '-n') {
  $file_name = $argv[$tag_index + 1];
} 

if ($argc == 7 || $argc == 5) {
  $initial_name = null;
  $tag_index = array_search('-i', $argv) ?? '';
  if ($argv[$tag_index] == '-i') {
    $initial_name = strtoupper($argv[$tag_index + 1]);
  } 

  $extend_class_name = null;
  $tag_index = array_search('-x', $argv) ?? '';
  if ($argv[$tag_index] == '-x') {
    $extend_class_name = $argv[$tag_index + 1];
  } 
}

foreach ($dirs as $dir) {
  if (!is_dir(dirname(__FILE__).'/'.$dir)) {
    mkdir(dirname(__FILE__).'/'.$dir, 0775);
  }

  if (!file_exists(dirname(__FILE__).'/'.$dir.'/'.$file_name.$initial_name.strtoupper($dir).'.php')) {
    $file = fopen(dirname(__FILE__).'/'.$dir.'/'.$file_name.$initial_name.strtoupper($dir).'.php', 'w');
  } else {
    echo "O arquivo \"".$file_name.$initial_name.strtoupper($dir).'.php" já existe e não pode ser sobrescrito!'.PHP_EOL;
    echo "Exit!".PHP_EOL;
    die();
  }

  $date = date('d/m/Y');
  $fullPath = dirname(__FILE__).'/'.$dir.'/'.$file_name.$initial_name.strtoupper($dir).'.php';
  $obj_name_file = $file_name.$initial_name;

  if (!$extend_class_name) {
    $extend_class_name = 'Infra';
  }

  if ($extend_class_name != 'Infra') {
    $montar = 'parent::montar();';
    $table_name_dto = "public function getStrNomeTabela() {
        return '#add_table_name';
      }";
  } else {
    $montar = '';
    $table_name_dto = '';
  }

  if ($dir == 'bd') {
    $content_file = "
    <?php
    /**
    * MINISTÉRIO PÚBLICO DO TOCANTINS
    *
    * $date - criado por PAULO ROBERTO TORRES - cli
    *
    */

    require_once dirname(__FILE__) . '/../../../Eproc.php';
    
    class {$obj_name_file}BD extends BDEproc {

      public function __construct(InfraIBanco \$objInfraIBanco){
         parent::__construct(\$objInfraIBanco);
      }
    
    }";

    file_put_contents( $fullPath, $content_file, $flags );
  }

  if ($dir == 'rn') {
    $content_file = "
    <?php

    /**
     * MINISTÉRIO PÚBLICO DO TOCANTINS
     *
     * $date - criado por PAULO ROBERTO TORRES - cli
     *
     */

    require_once dirname(__FILE__) . '/../../../Eproc.php';

    class {$obj_name_file}RN extends {$extend_class_name}RN {

      public function __construct(){
        parent::__construct();
      }
    
      protected function inicializarObjInfraIBanco(){
        return BancoEproc::getInstance();
      }

      protected function cadastrarControlado({$obj_name_file}DTO \$obj{$obj_name_file}DTO) {
        try{
          //Regras de negócio
          \$objInfraException = new InfraException();
          \$objInfraException->lancarValidacoes();

          \$obj{$obj_name_file}BD = new {$obj_name_file}BD(\$this->getObjInfraIBanco());
          \$ret = \$obj{$obj_name_file}BD->cadastrar(\$obj{$obj_name_file}DTO);

        }catch(Exception \$e){
          throw new InfraException('Erro cadastrando $obj_name_file.',\$e);
        }
      }//

      protected function alterarControlado({$obj_name_file}DTO \$obj{$obj_name_file}DTO){
        try {

          //Regras de Negocio
          \$objInfraException = new InfraException();  
          \$objInfraException->lancarValidacoes();

          \$obj{$obj_name_file}BD = new {$obj_name_file}BD(\$this->getObjInfraIBanco());
          \$obj{$obj_name_file}BD->alterar(\$obj{$obj_name_file}DTO);

        }catch(Exception \$e){
          throw new InfraException('Erro alterando {$obj_name_file}.',\$e);
        }
      }//

      protected function excluirControlado(\$arrObj{$obj_name_file}DTO){
        try {

          //Regras de Negocio
          //\$objInfraException = new InfraException();
          //\$objInfraException->lancarValidacoes();

          \$obj{$obj_name_file}BD = new {$obj_name_file}BD(\$this->getObjInfraIBanco());

          for(\$i=0;\$i<count(\$arrObj{$obj_name_file}DTO);\$i++){
            \$obj{$obj_name_file}BD->excluir(\$arrObj{$obj_name_file}DTO[\$i]);
          }


        }catch(Exception \$e){
          throw new InfraException('Erro excluindo $obj_name_file.',\$e);
        }
      }//

      protected function consultarConectado({$obj_name_file}DTO \$obj{$obj_name_file}DTO){
        try {
    
          //Valida Permissao
    
    
          //Regras de Negocio
          //\$objInfraException = new InfraException();
    
          //\$objInfraException->lancarValidacoes();
    
          \$obj{$obj_name_file}BD = new {$obj_name_file}BD(\$this->getObjInfraIBanco());
          \$ret = \$obj{$obj_name_file}BD->consultar(\$obj{$obj_name_file}DTO);
    
          //Auditoria
    
          return \$ret;
        }catch(Exception \$e){
          throw new InfraException('Erro consultando  {$obj_name_file}.',\$e);
        }
      }//


      protected function listarConectado({$obj_name_file}DTO \$obj{$obj_name_file}DTO) {
        try {
    
          //Valida Permissao
    
    
          //Regras de Negocio
          //\$objInfraException = new InfraException();
    
          //\$objInfraException->lancarValidacoes();
    
          \$obj{$obj_name_file}BD = new {$obj_name_file}BD(\$this->getObjInfraIBanco());
          \$ret = \$obj{$obj_name_file}BD->listar(\$obj{$obj_name_file}DTO);
    
          //Auditoria
    
          return \$ret;
    
        }catch(Exception \$e){
          throw new InfraException('Erro listando A{$obj_name_file}.',\$e);
        }
      }//

      protected function contarConectado({$obj_name_file}DTO \$obj{$obj_name_file}DTO){
        try {
    
          //Valida Permissao
    
    
          //Regras de Negocio
          //\$objInfraException = new InfraException();
    
          //\$objInfraException->lancarValidacoes();
    
          \$obj{$obj_name_file}BD = new {$obj_name_file}BD(\$this->getObjInfraIBanco());
          \$ret = \$obj{$obj_name_file}BD->contar(\$obj{$obj_name_file}DTO);
    
          //Auditoria
    
          return \$ret;
        }catch(Exception \$e){
          throw new InfraException('Erro contando {$obj_name_file}.',\$e);
        }
      }//

      protected function desativarControlado(\$arrObj{$obj_name_file}DTO){
        try {

            //Regras de Negocio
            //\$objInfraException = new InfraException();

            //\$objInfraException->lancarValidacoes();

            \$obj{$obj_name_file}BD = new {$obj_name_file}BD(\$this->getObjInfraIBanco());
            for (\$i = 0; \$i < count(\$arrObj{$obj_name_file}DTO); \$i++) {
                \$obj{$obj_name_file}BD->desativar(\$arrObj{$obj_name_file}DTO[\$i]);
            }

        } catch (Exception \$e) {
            throw new InfraException('Erro desativando {$obj_name_file}.', \$e);
        }
      }//

      protected function reativarControlado(\$arrObj{$obj_name_file}DTO)
      {
          try {
  
              //Regras de Negocio
              //\$objInfraException = new InfraException();
  
              //\$objInfraException->lancarValidacoes();
  
              \$obj{$obj_name_file}BD = new {$obj_name_file}BD(\$this->getObjInfraIBanco());
              for (\$i = 0; \$i < count(\$arrObj{$obj_name_file}DTO); \$i++) {
                  \$obj{$obj_name_file}BD->reativar(\$arrObj{$obj_name_file}DTO[\$i]);
              }
  
          } catch (Exception \$e) {
              throw new InfraException('Erro reativando {$obj_name_file}.', \$e);
          }
      }//

      protected function bloquearControlado({$obj_name_file}DTO \$obj{$obj_name_file}DTO){
        try {
            //Regras de Negocio
            //\$objInfraException = new InfraException();
            //\$objInfraException->lancarValidacoes();

            \$obj{$obj_name_file}BD = new {$obj_name_file}BD(\$this->getObjInfraIBanco());
            \$ret = \$obj{$obj_name_file}BD->bloquear(\$obj{$obj_name_file}DTO);

            return \$ret;
        }catch(Exception \$e){
            throw new InfraException('Erro bloqueando {$obj_name_file}.',\$e);
        }
    }

  }//Enc Class
    ";
    file_put_contents( $fullPath, $content_file, $flags );
  }//End If

  if ($dir == 'dto') {
    $content_file = "
    <?php
    /**
    * MINISTÉRIO PÚBLICO DO TOCANTINS
    *
    * $date - criado por PAULO ROBERTO TORRES - cli
    *
    */

    require_once dirname(__FILE__) . '/../../../Eproc.php';

    class {$obj_name_file}DTO extends {$extend_class_name}DTO {

      $table_name_dto

      public function montar() {
        $montar

        \$this->adicionarAtributoTabela(InfraDTO::\$PREFIXO_NUM, 'Id','id');
        \$this->adicionarAtributoTabela(InfraDTO::\$PREFIXO_STR, 'Coluna', 'coluna');
        \$this->adicionarAtributoTabela(InfraDTO::\$PREFIXO_DTH, 'Date', 'date');

        \$this->adicionarAtributoTabelaRelacionada(InfraDTO::\$PREFIXO_NUM, 'Valor', 'coluna_relacionada', 'a_outra_tabela');

        \$this->configurarPK('Id',InfraDTO::\$TIPO_PK_INFORMADO);

        \$this->configurarFK('Valor', 'a_outra_tabela', 'coluna_relacionada'); //MPE 2020
      }

    }//End Class
    ";
    file_put_contents( $fullPath, $content_file, $flags );
  } //End If

  if ($dir == 'int') {
    $content_file = "
    <?php
    /**
    * MINISTÉRIO PÚBLICO DO TOCANTINS
    *
    * $date - criado por PAULO ROBERTO TORRES - cli
    *
    */

    require_once dirname(__FILE__) . '/../../../Eproc.php';

    class {$obj_name_file}INT extends {$extend_class_name}INT
    {
        //public static function montarSelectEnvio(\$strPrimeiroItemValor, \$strPrimeiroItemDescricao, \$strValorItemSelecionado, \$strIdAcessoCodigo = '')
        //{
          //Exemplo de implementação mais comum
        //}
    }//End Class
    ";
    file_put_contents( $fullPath, $content_file, $flags );
  }//End If

}//End For
