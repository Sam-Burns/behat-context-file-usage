<?php
namespace BehatContextFileUsage;

use Behat\Testwork\EventDispatcher\Event\SuiteTested;
use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Behat\Testwork\EventDispatcher\Event\ExerciseCompleted;
use Behat\Testwork\EventDispatcher\TestworkEventDispatcher;
use PHP_CodeCoverage as CodeCoverageMonitor;
use PHP_CodeCoverage_Report_HTML as CodeCoverageWriter;

class Extension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $eventDispatcher = $container->get('event_dispatcher'); /** @var $eventDispatcher TestworkEventDispatcher */

        $coverageCalculator = new CoverageCalculator(
            new PhpUnitCodeCoverageTool(
                new CodeCoverageMonitor(),
                new CodeCoverageWriter(),
                $config
            )
        );

        $eventDispatcher->addListener(SuiteTested::BEFORE,      [$coverageCalculator, 'beNotifiedOfSuiteStartingEvent'],    100);
        $eventDispatcher->addListener(SuiteTested::AFTER,       [$coverageCalculator, 'beNotifiedOfSuiteFinishingEvent'],   100);
        $eventDispatcher->addListener(ExerciseCompleted::AFTER, [$coverageCalculator, 'beNotifiedOfExerciseFinishedEvent'], 100);
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('context_folder')->end()
                ->scalarNode('report_folder')->end()
                ->end()
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigKey()
    {
        return 'context_code_usage';
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager) {}

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container) {}
}
