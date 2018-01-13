<?php

use Jeremyfornarino\Band\BandFrequency;
use Jeremyfornarino\phpCliTools\Cli\Command;
use Jeremyfornarino\phpCliTools\Cli\Option;

class AddBandFrequency extends Command
{
    public function __construct(array $arguments)
    {
        parent::__construct($arguments);
        $this->setOptions([
            new Option("filePath", "f", "Lien vers le fichier de la base de données (Alphanumerique + \/)", "^([A-z0-9\/]+).json$", "bandDatabase.json"),
            new Option("bandName", "n", "Nom de la bande (Alphanumerique)", "^([A-z0-9]+)$"),
            new Option("freqStart", "s", "Frequence depart (Mhz)", "^([0-9]+)$"),
            new Option("freqStop", "t", "Frequence fin (Mhz)", "^([0-9]+)$"),
            new Option("rbw", "r", "RBW (Khz)", "^([0-9]+)$"),
            new Option("points", "p", "Points", "^([0-9]+)$"),
        ]);
    }
    public function execute()
    {
        echo "Adding band to BandFrequencyDB : ";
        $bandDB = new \Jeremyfornarino\Band\BandFrequencyDB(
            $this->getOptionsByName("filePath")->getValue()
        );
        $bandDB->loadDatabase();
        $band = new BandFrequency(
            $this->getOptionsByName("bandName")->getValue(),
            $this->getOptionsByName("freqStart")->getValue(),
            $this->getOptionsByName("freqStop")->getValue(),
            $this->getOptionsByName("rbw")->getValue(),
            $this->getOptionsByName("points")->getValue()
        );
        $bandDB->addBand($band);
        $bandDB->saveDatabase();
        echo "Done \n";
    }
}