<?php

/**
 * File containing the SystemInfoDumpCommand class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\EzSupportToolsBundle\Command;

use eZ\Publish\API\Repository\Values\ValueObject;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SystemInfoDumpCommand extends ContainerAwareCommand
{
    /**
     * Define command and input options.
     */
    protected function configure()
    {
        $this
            ->setName('ez-support-tools:dump-info')
            ->setDescription('Collects system information and dumps it.')
            ->addArgument(
                'info-collector',
                InputArgument::REQUIRED,
                'Which information collector should be used?'
            )
            ;
    }

    /**
     * Execute the Command.
     *
     * @param $input InputInterface
     * @param $output OutputInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $infoCollector = $this->getContainer()->get($input->getArgument('info-collector'));
        $infoValue = $infoCollector->build();

        $outputArray = [];
        // attributes() is deprecated, and getProperties() is protected. Smeg it, this is very temporary anyway.
        foreach ($infoValue->attributes() as $property) {
            if (is_array($infoValue->$property)) {
                foreach ($infoValue->$property as $subPropertyKey => $subPropertyEntry) {
                    if ($subPropertyEntry instanceof ValueObject) {
                        foreach ($subPropertyEntry->publicProperties() as $subProperty) {
                            $outputArray[$property][$subPropertyEntry->name][$subProperty] = $subPropertyEntry->$subProperty;
                        }
                    } else {
                        $outputArray[$property][$subPropertyKey] = $subPropertyEntry;
                    }
                }
            } else {
                $outputArray[$property] = $infoValue->$property;
            }
        }

        $output->writeln(var_export($outputArray, true));
    }
}
