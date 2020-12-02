<?php 

/**
 * Author: Ayrton Sousa Marinho
 * 
 */

include_once "modules/ZipperTree.php" ;

/**
 * Class responsible for generating a zip file, it uses the concept of m-ary tree, 
 * to build a preview of the zip file in a tree format. 
 */
class Zipper{

    private $zip;
    private $zipTree;
    private $slashType;
    public function __construct(){
        $this->zip = new ZipArchive();
        $this->zipTree = new ZipperTree();
    }

    /**
     * Responsible for building the tree and building the zip file
     */
    public function build($filename="new_zip_file.zip", $folder = ""){
        
    
        if($this->zip->open($filename, ZipArchive::CREATE) !== TRUE){
            exit("cannot open <$filename>\n");
        }

        echo "Building.. \n";
        $this->zipTree->setSlashType($folder);
        $this->zipTree->build($folder);
        // $this->zipTree->printTree($this->zipTree->getTree());
        $this->slashType = $this->zipTree->getSlashType();
        echo "Zipping...\n";
        $this->startZipping();

        $res = ($this->zip->status == 0)?" Success \n" : "Something went wrong \n";
      
        $this->zip->close();
        
    }


    private function startZipping(){
        $dataTree = $this->zipTree->getTree();
      
        $this->recursiveZip($dataTree, ""); 

    }

    private function recursiveZip($node,$abspath){
       
        if($node->isDir()){
            $folders = explode($this->slashType, $node->getValue());
            if($abspath !== "")
                $abspath = $abspath . $this->slashType . $folders[sizeof($folders)-1];
            else
                $abspath =  $folders[sizeof($folders)-1];

            $this->zip->addEmptyDir($abspath);
        }else{
            $folders = explode($this->slashType, $node->getValue());
            if($abspath !== "")
                $abspath = $abspath . $this->slashType . $folders[sizeof($folders)-1];
            else
                $abspath =  $folders[sizeof($folders)-1];
        
            
            $this->zip->addFile($node->getValue(),$abspath);
         
        }

        foreach($node->getChildren() as $child){
            
            $this->recursiveZip($child, $abspath);
            
        }


      
    }
}



$zipper = new Zipper();
$zipper->build($filename=$argv[1], $folder= $argv[2]);



?>