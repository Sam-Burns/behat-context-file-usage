<?php
namespace BehatContextFileUsage;

use PHP_CodeCoverage as CodeCoverageMonitor;
use PHP_CodeCoverage_Report_HTML as CodeCoverageReporter;

class PhpUnitCodeCoverageTool
{
    /** @var CodeCoverageMonitor */
    private $codeCoverageMonitor;

    /** @var CodeCoverageReporter */
    private $codeCoverageReporter;

    /**
     * @param CodeCoverageMonitor  $codeCoverageMonitor,
     * @param CodeCoverageReporter $codeCoverageReporter,
     * @param string[]             $config
     */
    public function __construct(
        CodeCoverageMonitor  $codeCoverageMonitor,
        CodeCoverageReporter $codeCoverageReporter,
        $config
    ) {
        $this->codeCoverageMonitor = $codeCoverageMonitor;
        $this->codeCoverageReporter  = $codeCoverageReporter;

        $this->reportFolder  = $config['report_folder'];

        $codeCoverageMonitor->filter()->addDirectoryToWhitelist($config['context_folder']);
    }

    /**
     * @param string $suiteName
     */
    public function startRecordingCodeUsageWithTestName($suiteName)
    {
        $this->codeCoverageMonitor->start($suiteName);
    }

    public function stopRecordingCodeUsage()
    {
        $this->codeCoverageMonitor->stop();
    }

    public function publishCodeUsageReport()
    {
        $this->codeCoverageReporter->process($this->codeCoverageMonitor, $this->reportFolder);
    }
}
