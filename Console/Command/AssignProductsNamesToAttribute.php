<?php

namespace Monogo\Recruitment\Console\Command;

use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Exception\LocalizedException;
use Monogo\Recruitment\Service\ConfigurationReader;
use Monogo\Recruitment\Service\AssignProducts;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AssignProductsNamesToAttribute extends Command
{
    /**
     * @var string
     */
    public const SIZE = 'size';

    /**
     * @var State
     */
    protected State $state;

    /**
     * @var ConfigurationReader
     */
    protected ConfigurationReader $configurationReader;

    /**
     * @var AssignProducts
     */
    protected AssignProducts $assignProductsService;

    /**
     * @param State $state
     * @param ConfigurationReader $configurationReader
     * @param AssignProducts $assignProductsService
     * @param string|null $name
     */
    public function __construct(
        State               $state,
        ConfigurationReader $configurationReader,
        AssignProducts      $assignProductsService,
        string              $name = null
    )
    {
        $this->state = $state;
        $this->configurationReader = $configurationReader;
        $this->assignProductsService = $assignProductsService;
        parent::__construct($name);
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('monogo:productsnames:assign')
            ->setDescription('Assign products names to product attribute');
        $this->addOption(
            self::SIZE,
            null,
            InputOption::VALUE_OPTIONAL,
            'Number of products to be assigned'
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     * @throws LocalizedException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->state->setAreaCode(Area::AREA_ADMINHTML);
        $this->output->writeln('Start');

        $size = $input->getOption(self::SIZE);

        $this->assignProductsService->assign((int)$size ?? (int)$this->configurationReader->getSizeOfProducts(), $this->output);
        $this->output->writeln('Stop');
    }
}
