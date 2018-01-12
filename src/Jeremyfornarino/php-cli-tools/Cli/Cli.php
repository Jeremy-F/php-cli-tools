<?php

namespace Jeremyfornarino\phpCliTools\Cli;


class Cli
{
    public static function run($argv){
        $arguments = self::initialize($argv);
        $commandFileClassPath = getcwd()."/commands/". $arguments["className"] . ".php";
        if(file_exists($commandFileClassPath)){
            require_once $commandFileClassPath;
            if(class_exists($arguments["className"])){
                /** @var Command $command */
                $command = new $arguments["className"]($arguments);
                $command->verifyOptions();
                $command->execute();
            }
        }
    }

    private static function initialize($argv) : array {
        $result = [];
        if($argv > 2) {
            $result["className"] = $argv[1];
            $argNumber = count($argv);
            for ($i = 2; $i < $argNumber; $i++) {
                $argument = $argv[$i];
                if (preg_match("#\-([A-z]+)#", $argument, $letter)) {
                    if ($argNumber == $i + 1) {
                        $result[$letter[1]] = true;
                    } else {
                        if (preg_match("#\-([A-z]+)#", $argv[$i + 1]) || !isset($argv[$i + 1])) {
                            $result[$letter[1]] = true;
                        } else {
                            $result[$letter[1]] = $argv[$i + 1];
                            $i++;
                        }
                    }
                }
            }
        }
        return $result;
    }
}