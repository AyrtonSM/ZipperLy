
<?php 

class ZipperTreeNode{
    private $parent;
    private $childrenValues;
    private $value;
    private $dir;

    public function __construct($root){
        $this->childrenValues = [];
        $this->value = $root;
    }

    public function addChild($child){
        array_push($this->childrenValues, $child);
    }

    public function setChildren($children){
        $this->childrenValues = $children;
    }

    public function getChildren(){
        return $this->childrenValues;
    }

    public function setParent($parent){
        $this->parent = $parent;
    }

    public function getParent(){
        return $this->parent;
    }

    public function getValue(){
        return $this->value;
    }
    public function setAsDir($dir){
        $this->dir = $dir;
    }
    public function setValue($value){
        $this->value = $value;
    }
    public function isDir(){
        return $this->dir;
    }

   

    

}

?>