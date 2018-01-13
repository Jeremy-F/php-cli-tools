<?php

use Jeremyfornarino\phpCliTools\Cli\Option;

class RunBandFrequency extends \Jeremyfornarino\phpCliTools\Cli\Command {

    public function __construct(array $arguments)
    {
        parent::__construct($arguments);
        $this->setOptions([
            new Option("filePath", "f", "Lien vers le fichier de la base de données", "", "bandDatabase.json", "^([A-z0-9\/]+).json$"),
            new Option("hostname", "h", "Lien vers l'analyzer de signal", "", "147.215.193.22")
        ]);
    }

    /**
     * @throws Exception
     */
    public function execute(){
        if(function_exists("curl_init")) {
            $signalAnalyzer = new \Jeremyfornarino\Ksac\SignalAnalyzer\SignalAnalyzer(
                $this->getOptionsByName("hostname")->getValue()
            );
            $bandDB = new \Jeremyfornarino\Band\BandFrequencyDB(
                $this->getOptionsByName("filePath")->getValue()
            );
            $bandDB->loadDatabase();
            echo "Lancement de l'analyze pour les bandes suivantes : \n" . $bandDB->__toString()."\n";
            echo "Faire CTRL+C pour arreter le processus";
            while (1 == 1) {
                $bandDB->run($signalAnalyzer);
            }
        }else{
            echo "php-curl est necesasire pour l'utilisation de cette commande";
        }
    }
}