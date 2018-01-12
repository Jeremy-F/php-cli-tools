<?php
/**
 * Created by IntelliJ IDEA.
 * User: jeremyfornarino
 * Date: 12/01/2018
 * Time: 16:55
 */

class RunBandFrequency extends \Jeremyfornarino\phpCliTools\Cli\Command {

    public function __construct(array $arguments)
    {
        parent::__construct($arguments);
        $this->setOptions([
            new Option("filePath", "f", "Lien vers le fichier de la base de données", "", "bandDatabase.json"),
            new Option("hostname", "h", "Lien vers l'analyzer de signal", "", "147.215.193.22")
        ]);
    }

    /**
     * @throws Exception
     */
    public function execute(){
        $signalAnalyzer = new \Jeremyfornarino\Ksac\SignalAnalyzer\SignalAnalyzer(
            $this->getOptionsByName("filePath")->getValue()
        );
        $bandDB = new \Jeremyfornarino\Band\BandFrequencyDB(
            $this->getOptionsByName("filePath")->getValue()
        );
        echo "Lancement de l'analyze pour les bandes suivantes : \n".$bandDB->__toString();
        echo "Faire CTRL+C pour arreter le processus";
        while (1 == 1){
            $bandDB->run($signalAnalyzer);
        }
    }
}