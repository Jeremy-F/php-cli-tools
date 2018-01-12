<?php
/**
 * Created by IntelliJ IDEA.
 * User: jeremyfornarino
 * Date: 12/01/2018
 * Time: 15:35
 */

namespace Jeremyfornarino\phpCliTools\Cli;


class Option{
    /** @var string */
    private $name;
    /** @var string */
    private $letterName;
    /** @var string */
    private $description;
    /** @var string */
    private $default;
    /** @var string */
    private $regex;

    private $value;


    /**
     * Option constructor.
     * @param string $name
     * @param string $letterName
     * @param string $description
     * @param string $regex
     * @param string|null $default
     */
    public function __construct(string $name, string $letterName, string $description = "", string $regex = "",string $default = null)
    {
        $this->name = $name;
        $this->letterName = $letterName;
        $this->description = $description;
        $this->regex = $regex;
        $this->default = $default;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLetterName(): string
    {
        return $this->letterName;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return $this->default;
    }

    public function setValueFromCLI(){
        $beforeSTDIN = $this->getDescription() . ((is_null($this->getDefault()))?"":" [{$this->getDefault()}]")." : ";
        $continue = true;
        do{
            echo $beforeSTDIN;
            $value = trim(fgets(STDIN));

            $test = strlen($value) == 0 && $this->hasDefault();
            if($test){
                $this->setValue($this->getDefault());
                $continue = false;
            } else if($this->hasRegex()){
                if(preg_match("#{$this->getRegex()}#", $value)) {
                    $this->setValue($value);
                    $continue = false;
                }
            }else if(strlen($value) > 0){
                $this->setValue($value);
                $continue = false;
            }

            if($continue){
                echo "Bad value : expected #{$this->getRegex()}#\n";
            }
        }while($continue);
        return;
    }

    public function setValue($param)
    {
        $this->value = $param;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getRegex(): string
    {
        return $this->regex;
    }

    private function hasRegex()
    {
        return strlen($this->getRegex()) > 0 && $this->getRegex() != "";
    }

    private function hasDefault()
    {
        return !is_null($this->getDefault());
    }


}