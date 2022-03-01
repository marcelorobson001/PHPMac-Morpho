<?php
namespace marcelorobson001\PHPMacMorpho;

class tag{
    function _tag_sents($sents){
        $tag_sents=[];
        for ($sent = 0; $sent < count($sents); $sent++) {
          $tag_sent=array(count($sents[$sent]));
          $tag_sents[]=$this->_tag($sents[$sent]);
        }
        return $tag_sents;
    }
    function _tag($sent){
        $dbh = new \PDO('sqlite:'.__DIR__.'\BigramTagger_Mac_morpho.db');
        $tag_sent=array(count($sent));
        for($word = 0; $word < count($sent); $word++) {
            if($word ===0){
                $search_forms=' +';
            }else{
                $search_forms=$tag_sent[$word-1].'+';
            }
            //aspas simples em ambos
            if(mb_strpos($search_forms,'"')===false and mb_strpos($sent[$word],'"')===false){
                $sql_parametro='"'.$search_forms.$sent[$word].'"';
            //aspas duplas em ambos
            }elseif(mb_strpos($search_forms,"'")===false and mb_strpos($sent[$word],'"')===false){
                $sql_parametro="'".$search_forms.$sent[$word]."'";
            //aspas duplas apenas no primeiro
            }elseif(mb_strpos($search_forms,"'")!==false and mb_strpos($sent[$word],"'")===false){
                $sql_parametro='"'.$search_forms.'"||'."'".$sent[$word]."'";
            //aspas simples apenas no primeiro
            }elseif(mb_strpos($search_forms,"'")===false and mb_strpos($sent[$word],"'")!==false){
              $sql_parametro="'".$search_forms."'||".'"'.$sent[$word].'"';
            }
            $db = $dbh->query('SELECT tags FROM BigramTagger where forms like '.$sql_parametro);
            $data=$db->fetch()['tags'];
            if(strlen($data)===0){
                $db = $dbh->query('SELECT tags FROM UnigramTagger where forms like "'.$sent[$word].'"');
                $data=$db->fetch()['tags'];
                if(strlen($data)===0){
                    $data='None';
                }
            }
            $tag_sent[$word]=$data; 
        }
      return $tag_sent;
    }
         
}
/*
function _tag_sents($sents){
  $tag_sents=[];
  for ($sent = 0; $sent < count($sents); $sent++) {
    $tag_sent=array(count($sents[$sent]));
    $tag_sents[]=_tag($sents[$sent]);
  }
  return $tag_sents;
}


function _tag($sent){
      $dbh = new \PDO('sqlite:'.__DIR__.'\\BigramTagger_Mac_morpho.db');
      $tag_sent=array(count($sent));
      for($word = 0; $word < count($sent); $word++) {
          if($word ===0){
              $search_forms=' +';
          }else{
              $search_forms=$tag_sent[$word-1].'+';
          }
          //aspas simples em ambos
          if(mb_strpos($search_forms,'"')===false and mb_strpos($sent[$word],'"')===false){
              $sql_parametro='"'.$search_forms.$sent[$word].'"';
          //aspas duplas em ambos
          }elseif(mb_strpos($search_forms,"'")===false and mb_strpos($sent[$word],'"')===false){
              $sql_parametro="'".$search_forms.$sent[$word]."'";
          //aspas duplas apenas no primeiro
          }elseif(mb_strpos($search_forms,"'")!==false and mb_strpos($sent[$word],"'")===false){
              $sql_parametro='"'.$search_forms.'"||'."'".$sent[$word]."'";
          //aspas simples apenas no primeiro
          }elseif(mb_strpos($search_forms,"'")===false and mb_strpos($sent[$word],"'")!==false){
            $sql_parametro="'".$search_forms."'||".'"'.$sent[$word].'"';
          }
          $db = $dbh->query('SELECT tags FROM BigramTagger where forms like '.$sql_parametro);
          $data=$db->fetch()['tags'];
          if(strlen($data)===0){
              $db = $dbh->query('SELECT tags FROM UnigramTagger where forms like "'.$sent[$word].'"');
              $data=$db->fetch()['tags'];
              $data='None';
          }
          $tag_sent[$word]=$data; 
      }
    return $tag_sent;
}*/
?>