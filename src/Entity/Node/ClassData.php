<?php

namespace Entity\Node;

use Entity\FQCN;
use Entity\Collection\MethodsCollection;
use Entity\Collection\PropertiesCollection;

class ClassData{
    const MODIFIER_PUBLIC    =  1;
    const MODIFIER_PROTECTED =  2;
    const MODIFIER_PRIVATE   =  4;
    const MODIFIER_STATIC    =  8;
    const MODIFIER_ABSTRACT  = 16;
    const MODIFIER_FINAL     = 32;
    public $interfaces      = [];
    public $constants       = [];
    /** @var Uses */
    public $uses;

    /**
     * @var FQCN
     */
    public $fqcn;
    public $doc             = "";
    public $startLine       = 0;
    public $file            = "";
    public function __construct(FQCN $fqcn, $file){
        $this->constants = [];
        $this->fqcn = $fqcn;
        $this->file = $file;
        $this->methods = new MethodsCollection($this);
        $this->properties = new PropertiesCollection($this);
    }
    /**
     * @return ClassData
     */
    public function getParent(){
        return $this->parent;
    }
    public function getName(){
        return $this->fqcn->getClassName();
    }
    public function setParent($parent){
        $this->parent = $parent;
    }
    public function addInterface($interface){
        if(!in_array($interface, $this->interfaces)){
            $this->interfaces[] = $interface;
        }
    }
    public function addMethod(MethodData $method){
        $this->methods->add($method);
    }
    public function addProp(ClassProperty $prop){
        $this->properties->add($prop);
    }
    public function addConst($constName){
        $this->constants[$constName] = $constName;
    }
    public function __get($name){
        if($name === 'methods'){
            return $this->methods;
        }
        elseif($name === 'properties'){
            return $this->properties;
        }
    }

    private $parent;
    private $methods;
    private $properties;
}
