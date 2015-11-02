<?php
namespace BehatContextFileUsage;

use Behat\Testwork\EventDispatcher\Event\AfterExerciseCompleted;
use Behat\Testwork\EventDispatcher\Event\AfterSuiteTested as AfterSuiteTestedEvent;
use Behat\Testwork\EventDispatcher\Event\BeforeSuiteTested as BeforeSuiteTestedEvent;
use Behat\Testwork\EventDispatcher\TestworkEventDispatcher as EventDispatcher;

class CoverageCalculator
{
    /** @var PhpunitCodeCoverageTool */
    private $phpUnitCodeCoverageTool;

    /**
     * @param PhpunitCodeCoverageTool $phpUnitCodeCoverageTool
     */
    public function __construct(PhpunitCodeCoverageTool $phpUnitCodeCoverageTool)
    {
        $this->phpUnitCodeCoverageTool = $phpUnitCodeCoverageTool;
    }

    /**
     * @throws \InvalidArgumentException
     *
     * @param BeforeSuiteTestedEvent $event
     * @param string                 $eventName
     * @param EventDispatcher        $eventDispatcher
     */
    public function beNotifiedOfSuiteStartingEvent(BeforeSuiteTestedEvent $event, $eventName, EventDispatcher $eventDispatcher)
    {
        $suiteName = $event->getSuite()->getName();
        $this->phpUnitCodeCoverageTool->startRecordingCodeUsageWithTestName($suiteName);
    }

    /**
     * @throws \InvalidArgumentException
     *
     * @param AfterSuiteTestedEvent $event
     * @param string                $eventName
     * @param EventDispatcher       $eventDispatcher
     */
    public function beNotifiedOfSuiteFinishingEvent(AfterSuiteTestedEvent $event, $eventName, EventDispatcher $eventDispatcher)
    {
        $this->phpUnitCodeCoverageTool->stopRecordingCodeUsage();
    }

    /**
     * @throws \InvalidArgumentException
     *
     * @param AfterExerciseCompleted $event
     * @param string                 $eventName
     * @param EventDispatcher        $eventDispatcher
     */
    public function beNotifiedOfExerciseFinishedEvent(AfterExerciseCompleted $event, $eventName, EventDispatcher $eventDispatcher)
    {
        $this->phpUnitCodeCoverageTool->stopRecordingCodeUsage();
        $this->phpUnitCodeCoverageTool->publishCodeUsageReport();
    }
}
