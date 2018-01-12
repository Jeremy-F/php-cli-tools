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
            new Option("filePath", "f", "Lien vers le fichier de la base de données", "", "bandDatabase.json"),
            new Option("bandName", "n", "Nom de la bande (pas d'espace, ni d'accents)"),
            new Option("freqStart", "s", "Frequence depart (Mhz)"),
            new Option("freqStop", "t", "Frequence fin (Mhz)"),
            new Option("rbw", "r", "RBW (Khz)"),
            new Option("points", "p", "Points"),
        ]);
    }
    public function execute()
    {
        echo "Adding band to BandFrequencyDB : ";
        $bandDB = new \Jeremyfornarino\Band\BandFrequencyDB(
            $this->getOptionsByName("filePath")->getValue()
        );
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