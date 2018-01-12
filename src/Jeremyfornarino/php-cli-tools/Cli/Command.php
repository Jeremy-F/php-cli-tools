<?php

namespace Jeremyfornarino\phpCliTools\Cli;


abstract class Command{

    /** @var array */
    private $arguments;

    /** @var array */
    private $options;

    /**
     * Command constructor.
     * @param array $arguments
     */
    public function __construct(array $arguments){
        $this->arguments = $arguments;
        $this->options = [];
    }
    public function verifyOptions(){
        /** @var Option $option */
        foreach ($this->getOptions() AS $option){
            $valueLetterName = $this->getArgumentValue($option->getLetterName());
            $valueName= $this->getArgumentValue($option->getName());

            $option->setValue(
                (!is_null($valueLetterName))?
                    $valueLetterName:
                    (
                        (!is_null($valueName))
                            ?$valueName:
                            null
                    )
            );

            if(is_null($option->getValue())){
                $option->setValueFromCLI();
            }
        }
    }
    abstract public function execute();
    private function getArgumentValue($key){
        return (array_key_exists($key, $this->arguments))?$this->arguments[$key]:null;
    }


    protected function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    protected function getOptionsByName($name){
        /** @var Option $option */
        foreach ($this->getOptions() AS $option){
            if($option->getName() == $name){
                return $option;
            }
        }
        return null;
    }
}