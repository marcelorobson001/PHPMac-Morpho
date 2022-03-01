# PHPMac-Morpho
Tagger sequential PHP utilizando BD SQlite com unigrams e bigramas retirados do corpus mac-morpho.

## Instalação
composer require marcelorobson001/phpmac-morpho

## Utilização
```
require(__DIR__.'\vendor\autoload.php');

use marcelorobson001\PHPMacMorpho\tag;
$tag_sents=new tag();

//Exemplo 1
$sents = [["eu",'gosto','de','comer','abacate']];
print_r($tag_sents->_tag_sents($sents));

//Exemplo2
$sent= ['O', 'sábio', 'nunca', 'diz', 'tudo', 'o', 'que', 'pensa,', 'mas', 'pensa', 'sempre', 'tudo', 'o', 'que', 'diz.', 'Pensamos', 'demasiadamente', 'e', 'sentimos', 'muito', 'pouco.', 'Necessitamos', 'mais', 'de', 'humildade', 'que', 'de', 'máquinas.'];
print_r($tag_sents->_tag($sent));
```
