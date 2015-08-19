<?php
namespace BehatContextFileUsage\ContextCodeUsage;

use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Behat\Testwork\EventDispatcher\Event\ExerciseCompleted;
use PHP_CodeCoverage as CodeCoverageMonitor;
use PHP_CodeCoverage_Report_HTML as CodeCoverageWriter;

class Extension implements ExtensionInterface
{
    /**
     * Returns the extension config key.
     *
     * @return string
     */
    public function getConfigKey()
    {
        return 'context_code_usage';
    }

    /**
     * @{inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager) {}

    /**
     * Setups configuration for the extension.
     *
     * @param ArrayNodeDefinition $builder
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
     * Loads extension services into temporary container.
     *
     * @param ContainerBuilder $container
     * @param array            $config
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $eventDispatcher = $container->get('event_dispatcher');
        /** @var $eventDispatcher \Behat\Testwork\EventDispatcher\TestworkEventDispatcher */

        $coverageCalculator = new CoverageCalculator(new CodeCoverageMonitor(), new CodeCoverageWriter(), $config);

        $eventDispatcher->addListener(ExerciseCompleted::BEFORE, [$coverageCalculator, 'beNotifiedOfExerciseStartedEvent'],  1);
        $eventDispatcher->addListener(ExerciseCompleted::AFTER,  [$coverageCalculator, 'beNotifiedOfExerciseFinishedEvent'], 1);
    }

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container) {}
}
