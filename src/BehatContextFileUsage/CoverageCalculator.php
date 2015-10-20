<?php
namespace BehatContextFileUsage;

use PHP_CodeCoverage as CodeCoverageMonitor;
use PHP_CodeCoverage_Report_HTML as CodeCoverageWriter;

class CoverageCalculator
{
    /** @var CodeCoverageMonitor */
    private $codeCoverageMonitor;

    /** @var CodeCoverageWriter */
    private $codeCoverageWriter;

    /** @var string */
    private $reportFolder;

    /**
     * @param CodeCoverageMonitor $codeCoverageMonitor,
     * @param CodeCoverageWriter  $codeCoverageWriter,
     * @param string[]            $config
     */
    public function __construct(
        CodeCoverageMonitor $codeCoverageMonitor,
        CodeCoverageWriter  $codeCoverageWriter,
        $config
    ) {
        $this->codeCoverageMonitor = $codeCoverageMonitor;
        $this->codeCoverageWriter  = $codeCoverageWriter;

        $this->reportFolder  = $config['report_folder'];

        $codeCoverageMonitor->filter()->addDirectoryToWhitelist($config['context_folder']);
    }

    public function beNotifiedOfExerciseStartedEvent()
    {
        $this->startRecordingCodeUsage();
    }

    public function beNotifiedOfExerciseFinishedEvent()
    {
        $this->stopRecordingCodeUsage();
        $this->publishCodeUsageReport();
    }

    private function startRecordingCodeUsage()
    {
        $this->codeCoverageMonitor->start('everything');
    }

    private function stopRecordingCodeUsage()
    {
        $this->codeCoverageMonitor->stop();
    }

    private function publishCodeUsageReport()
    {
        $this->codeCoverageWriter->process($this->codeCoverageMonitor, $this->reportFolder);
    }
}
