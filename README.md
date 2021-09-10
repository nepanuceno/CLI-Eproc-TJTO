# CLI-Eproc-TJTO

Projeto pessoal para agilizar a criação de classes de funcionaliodades no Sistema Eproc

O arquivo eproccli.php deverá ser clonado no diretório raíz do módulo em que o desenvolvedor
deseja criar os arquivos:

* BD -> ExempoBD.php
* DTO -> ExemploDTO.php
* INT -> ExemploINT.php
* RN -> ExemploRN.php

## Utilização

No diretório raiz do módulo, execute o ```./eprocli.php -i MP -n Processo -x Exemplo```
Lembrando que antes você deverá dar a permissão de execução ao **eprocli.php**

### Options:
          -i: Initials (MP, DPE, TJTO, TRF4 etc) Opcional
          -n: Name - Obrigatorio
          -x: Extends Class - (Ex: class ProcessoMPDTO extends ExemploDTO) - Opcional
          -h: Help
          
No exemplo de utilização acima, o cli irá gerar os arquivo com as suas respectivas classes extendidas às classes originais do core do Eproc.

#### Exemplo:
```class ProcessoMPDTO extends ExemploDTO {...}```

Caso as classes a serem geradas não necessitem serem extendidas de outras classes do core do Eproc,
basta omitir a opção **-x NomeDaClasse**
Lembrando que a opção **-i foo** também é opcional, caso você descida não acrescentar um sufixo no seu
módulo ao nome das classes e suas respectivas variáveis.