
    <?php
    /**
    * MINISTÉRIO PÚBLICO DO TOCANTINS
    *
    * 10/09/2021 - criado por PAULO ROBERTO TORRES - cli
    *
    */

    require_once dirname(__FILE__) . '/../../../Eproc.php';

    class ProcessoMPDTO extends ExemploDTO {

      public function getStrNomeTabela() {
        return '#add_table_name';
      }

      public function montar() {
        parent::montar();

        $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM, 'Id','id');
        $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'Coluna', 'coluna');
        $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_DTH, 'Date', 'date');

        $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_NUM, 'Valor', 'coluna_relacionada', 'a_outra_tabela');

        $this->configurarPK('Id',InfraDTO::$TIPO_PK_INFORMADO);

        $this->configurarFK('Valor', 'a_outra_tabela', 'coluna_relacionada'); //MPE 2020
      }

    }//End Class
    