
    <?php

    /**
     * MINISTÉRIO PÚBLICO DO TOCANTINS
     *
     * 10/09/2021 - criado por PAULO ROBERTO TORRES - cli
     *
     */

    require_once dirname(__FILE__) . '/../../../Eproc.php';

    class ProcessoMPRN extends ExemploRN {

      public function __construct(){
        parent::__construct();
      }
    
      protected function inicializarObjInfraIBanco(){
        return BancoEproc::getInstance();
      }

      protected function cadastrarControlado(ProcessoMPDTO $objProcessoMPDTO) {
        try{
          //Regras de negócio
          $objInfraException = new InfraException();
          $objInfraException->lancarValidacoes();

          $objProcessoMPBD = new ProcessoMPBD($this->getObjInfraIBanco());
          $ret = $objProcessoMPBD->cadastrar($objProcessoMPDTO);

        }catch(Exception $e){
          throw new InfraException('Erro cadastrando ProcessoMP.',$e);
        }
      }//

      protected function alterarControlado(ProcessoMPDTO $objProcessoMPDTO){
        try {

          //Regras de Negocio
          $objInfraException = new InfraException();  
          $objInfraException->lancarValidacoes();

          $objProcessoMPBD = new ProcessoMPBD($this->getObjInfraIBanco());
          $objProcessoMPBD->alterar($objProcessoMPDTO);

        }catch(Exception $e){
          throw new InfraException('Erro alterando ProcessoMP.',$e);
        }
      }//

      protected function excluirControlado($arrObjProcessoMPDTO){
        try {

          //Regras de Negocio
          //$objInfraException = new InfraException();
          //$objInfraException->lancarValidacoes();

          $objProcessoMPBD = new ProcessoMPBD($this->getObjInfraIBanco());

          for($i=0;$i<count($arrObjProcessoMPDTO);$i++){
            $objProcessoMPBD->excluir($arrObjProcessoMPDTO[$i]);
          }


        }catch(Exception $e){
          throw new InfraException('Erro excluindo ProcessoMP.',$e);
        }
      }//

      protected function consultarConectado(ProcessoMPDTO $objProcessoMPDTO){
        try {
    
          //Valida Permissao
    
    
          //Regras de Negocio
          //$objInfraException = new InfraException();
    
          //$objInfraException->lancarValidacoes();
    
          $objProcessoMPBD = new ProcessoMPBD($this->getObjInfraIBanco());
          $ret = $objProcessoMPBD->consultar($objProcessoMPDTO);
    
          //Auditoria
    
          return $ret;
        }catch(Exception $e){
          throw new InfraException('Erro consultando  ProcessoMP.',$e);
        }
      }//


      protected function listarConectado(ProcessoMPDTO $objProcessoMPDTO) {
        try {
    
          //Valida Permissao
    
    
          //Regras de Negocio
          //$objInfraException = new InfraException();
    
          //$objInfraException->lancarValidacoes();
    
          $objProcessoMPBD = new ProcessoMPBD($this->getObjInfraIBanco());
          $ret = $objProcessoMPBD->listar($objProcessoMPDTO);
    
          //Auditoria
    
          return $ret;
    
        }catch(Exception $e){
          throw new InfraException('Erro listando AProcessoMP.',$e);
        }
      }//

      protected function contarConectado(ProcessoMPDTO $objProcessoMPDTO){
        try {
    
          //Valida Permissao
    
    
          //Regras de Negocio
          //$objInfraException = new InfraException();
    
          //$objInfraException->lancarValidacoes();
    
          $objProcessoMPBD = new ProcessoMPBD($this->getObjInfraIBanco());
          $ret = $objProcessoMPBD->contar($objProcessoMPDTO);
    
          //Auditoria
    
          return $ret;
        }catch(Exception $e){
          throw new InfraException('Erro contando ProcessoMP.',$e);
        }
      }//

      protected function desativarControlado($arrObjProcessoMPDTO){
        try {

            //Regras de Negocio
            //$objInfraException = new InfraException();

            //$objInfraException->lancarValidacoes();

            $objProcessoMPBD = new ProcessoMPBD($this->getObjInfraIBanco());
            for ($i = 0; $i < count($arrObjProcessoMPDTO); $i++) {
                $objProcessoMPBD->desativar($arrObjProcessoMPDTO[$i]);
            }

        } catch (Exception $e) {
            throw new InfraException('Erro desativando ProcessoMP.', $e);
        }
      }//

      protected function reativarControlado($arrObjProcessoMPDTO)
      {
          try {
  
              //Regras de Negocio
              //$objInfraException = new InfraException();
  
              //$objInfraException->lancarValidacoes();
  
              $objProcessoMPBD = new ProcessoMPBD($this->getObjInfraIBanco());
              for ($i = 0; $i < count($arrObjProcessoMPDTO); $i++) {
                  $objProcessoMPBD->reativar($arrObjProcessoMPDTO[$i]);
              }
  
          } catch (Exception $e) {
              throw new InfraException('Erro reativando ProcessoMP.', $e);
          }
      }//

      protected function bloquearControlado(ProcessoMPDTO $objProcessoMPDTO){
        try {
            //Regras de Negocio
            //$objInfraException = new InfraException();
            //$objInfraException->lancarValidacoes();

            $objProcessoMPBD = new ProcessoMPBD($this->getObjInfraIBanco());
            $ret = $objProcessoMPBD->bloquear($objProcessoMPDTO);

            return $ret;
        }catch(Exception $e){
            throw new InfraException('Erro bloqueando ProcessoMP.',$e);
        }
    }

  }//Enc Class
    