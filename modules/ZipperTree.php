<?php 

include_once "ZipperTreeNode.php";

/**
 * Tree resposible for storing the folders, subfolders and files
 */
class ZipperTree {

    private $root;
    private $nodes;
    private $slashType;

    public function __construct(){
        $this->nodes = [];
    }

    public function build($rootPath){
        $this->setSlashType($rootPath);
        
        if($this->root === null){
            $this->root = new ZipperTreeNode($rootPath);
        }
        
        $this->root = $this->_build($this->root, $rootPath);
       
    }

    public function printTree($node){
                
        print( $node->getValue() ."\n");
        
        foreach($node->getChildren() as $child){
          
            $this->printTree($child);
        }
       
        
    }

    private function _build($node, $rootPath){

       
        if($node->getChildren() === []){
         
            if(is_dir($rootPath)){
                $dirData = scandir($rootPath,1);
                
                $node->setAsDir(TRUE);        
                unset($dirData[sizeof($dirData) - 1]);
                unset($dirData[sizeof($dirData) - 1]);
                
                foreach($dirData as $child){
                    $node->setParent($rootPath);
                    $node->addChild(new ZipperTreeNode( $node->getParent() . $this->slashType. $child));
                }
            }

            

        }
       
        foreach($node->getChildren() as $child){
            
            $path = $child->getValue();
 
            if(is_dir($path)){
                $child->setAsDir(TRUE);
                
            }
            $this->_build($child, $path);
          
        }
        return $node;
    }

    public function getTree(){
        return $this->root;
    }

    public  function setSlashType($folder){
        if(strpos($folder, "//") !== false){
            $this->slashType = "//";
        }else if (strpos($folder, "\\") !== false){
            $this->slashType = "\\";
        }else if((strpos($folder, "/") !== false)){
            $this->slashType = "/";
        }
    }

    public function getSlashType(){
        return $this->slashType;
    }






}
?>