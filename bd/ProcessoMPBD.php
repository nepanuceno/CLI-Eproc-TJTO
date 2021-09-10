
    <?php
    /**
    * MINISTÉRIO PÚBLICO DO TOCANTINS
    *
    * 10/09/2021 - criado por PAULO ROBERTO TORRES - cli
    *
    */

    require_once dirname(__FILE__) . '/../../../Eproc.php';
    
    class ProcessoMPBD extends BDEproc {

      public function __construct(InfraIBanco $objInfraIBanco){
         parent::__construct($objInfraIBanco);
      }
    
    }