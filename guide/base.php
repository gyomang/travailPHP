<?php
    class MyTable
    {
        private $id;
        private $nom;
        private $adresse;
        private $prix;
        private $commentaire;
        private $note;
        private $visite;

        private $co;
        private $table;
        private $stat;
        private $nbCol;

        // =========

        public function __construct($table)
        {
           /* try {
              
            } catch (PDOException $e) {
                $this->co="error bdd ".$e->getMessage();
            }*/

                $this->co=new PDO('mysql:host=localhost;dbname=guide','root','',
                    array(
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_NUM
                    )
                );

            $this->table=$table;
            $sql="select * from ".$this->table;
            $this->stat=$this->co->prepare($sql);
            //$pdostat->bindParam(":table",$table);
            $this->stat->execute();
        }


        // =========

        public function getId(){
            return $this->id;
        }
        public function getNom(){
            return $this->nom;
        }
        public function getAdresse(){
            return $this->adresee;
        }
        public function getPrix(){
            return $this->prix;
        }
        public function getCommentaire(){
            return $this->commentaire;
        }
        public function getNote(){
            return $this->note;
        }
        public function getVisite(){
            return $this->visite;
        }
   
        //=========

        public function rendreHTML()
        {
            $chaine="<table class='table table-dark table-over'>";

            //var_dump($this->lol);
            $chaine.=$this->infoTable();
            
            while ($row=$this->stat->fetch()) {
                $chaine.="<tr>";
                
                
                //var_dump($row);
                for ($i=0; $i < count($row); $i++) { 
                    if ($i==0) {
                        $chaine.="<td href='base.php?id=".$i.">".$row[$i]."</td>";
                    }else {
                        $chaine.="<td>".$row[$i]."</td>";
                    }
                }

                $chaine.="</tr>";
            }
            $chaine.="</table>";

            echo $chaine;
        }

        private function infoTable(){
            // $sql = $this->co->query(
            //     'SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = "'.$this->table.'" ;'
            // );
            // //var_dump($sql);
            // while ($donnees[] = $sql->fetch( PDO::FETCH_ASSOC ) )
            // {
                
            // }     

            
          
            $info=[] ;
            $chaine="<tr>";
            for ($i=0; $i < $this->stat->columnCount(); $i++) { 
                $info[$i]=$this->stat->getColumnMeta($i);

                foreach ($info[$i] as $key => $value) 
                {  
                    if ($key=="flags" && count($value)>1 && $value[1]=="primary_key") {
                        $j=$i;
                        $lol = " - ".$value [1];
                        
                    }           
                }

                foreach ($info[$i] as $key => $value) {
                    if ($key=='name') {
                        $chaine.="<th>";
                        if ($i==$j) {
                            $chaine.= $value.$lol;
                        }else {
                            $chaine.= $value;
                        }
                        $chaine.="</th>";
                       
                    }
                }

            }
            $chaine.="</tr>";
            //var_dump($chaine);

            return $chaine;
        }

        public function modifierOccurence($_id, array $tab){
            $sql="UPDATE ".$this->table." set nom=:nom, adresse=:adresse, prix=:prix, commentaire=:commentaire, note=:note,visite=:visite WHERE id = ".$_id;
            $stat=$this->co->prepare($sql);

            $stat->bindParam(":nom",$tab[0],PDO::PARAM_STR);
            $stat->bindParam(":adresse",$tab[1],PDO::PARAM_STR);
            $stat->bindParam(":prix",$tab[2],PDO::PARAM_STR);
            $stat->bindParam(":commentaire",$tab[3],PDO::PARAM_STR);
            $stat->bindParam(":note",$tab[4],PDO::PARAM_STR);
            $stat->bindParam(":visite",$tab[5],PDO::PARAM_STR);
            
            $stat->execute();
            $nbLigne=$stat->rowCount();
            
            if ($nbLigne==1) {
                return "modif reussi";
            }else {
                return "modif impossible";
            }
        } 
    }  
?>