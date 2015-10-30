<?php
namespace BehatContextFileUsage;

use Behat\Testwork\EventDispatcher\TestworkEventDispatcher as EventDispatcher;
use Behat\Testwork\EventDispatcher\Event\LifecycleEvent as Event;
use Behat\Testwork\EventDispatcher\Event\SuiteTested as SuiteTestedEvent;
use Behat\Testwork\EventDispatcher\Event\ExerciseCompleted as ExerciseCompletedEvent;

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
     * @param Event           $event
     * @param string          $eventName
     * @param EventDispatcher $eventDispatcher
     */
    public function beNotifiedOfSuiteStartingEvent(Event $event, $eventName, EventDispatcher $eventDispatcher)
    {
        $this->verifyEventType(SuiteTestedEvent::BEFORE, $eventName);

        $suiteName = $event->getSuite()->getName();

        $this->phpUnitCodeCoverageTool->startRecordingCodeUsageWithTestName($suiteName);
    }

    /**
     * @throws \InvalidArgumentException
     *
     * @param Event           $event
     * @param string          $eventName
     * @param EventDispatcher $eventDispatcher
     */
    public function beNotifiedOfSuiteFinishingEvent(Event $event, $eventName, EventDispatcher $eventDispatcher)
    {
        $this->verifyEventType(SuiteTestedEvent::AFTER, $eventName);

        $this->phpUnitCodeCoverageTool->stopRecordingCodeUsage();
    }

    /**
     * @throws \InvalidArgumentException
     *
     * @param Event           $event
     * @param string          $eventName
     * @param EventDispatcher $eventDispatcher
     */
    public function beNotifiedOfExerciseFinishedEvent(Event $event, $eventName, EventDispatcher $eventDispatcher)
    {
        $this->verifyEventType(ExerciseCompletedEvent::AFTER, $eventName);

        $this->phpUnitCodeCoverageTool->stopRecordingCodeUsage();
        $this->phpUnitCodeCoverageTool->publishCodeUsageReport();
    }

    /**
     * @throws \InvalidArgumentException
     *
     * @param string $expectedEventType
     * @param string $actualEventType
     */
    private function verifyEventType($expectedEventType, $actualEventType)
    {
        if ($actualEventType !== $expectedEventType) {
            throw new \InvalidArgumentException('Listener called with wrong event');
        }
    }
}
