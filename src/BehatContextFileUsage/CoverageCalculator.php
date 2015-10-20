<?php
namespace BehatContextFileUsage;

class CoverageCalculator
{
    /** @var \PHP_CodeCoverage */
    private $codeCoverageMonitor;

    /** @var \PHP_CodeCoverage_Report_HTML */
    private $codeCoverageWriter;

    /** @var string */
    private $reportFolder;

    /**
     * @param \PHP_CodeCoverage              $codeCoverageMonitor,
     * @param \PHP_CodeCoverage_Report_HTML  $codeCoverageWriter,
     * @param string[]                       $config
     */
    public function __construct(
        \PHP_CodeCoverage              $codeCoverageMonitor,
        \PHP_CodeCoverage_Report_HTML  $codeCoverageWriter,
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
