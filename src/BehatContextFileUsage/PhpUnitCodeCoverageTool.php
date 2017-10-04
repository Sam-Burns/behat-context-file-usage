<?php
namespace BehatContextFileUsage;

use SebastianBergmann\CodeCoverage\CodeCoverage;
use SebastianBergmann\CodeCoverage\Report\Html\Facade as HtmlReport;

class PhpUnitCodeCoverageTool
{
    /** @var CodeCoverage */
    private $codeCoverageMonitor;

    /** @var HtmlReport */
    private $codeCoverageReporter;

    /** @var string */
    private $reportFolder;

    /**
     * @param CodeCoverage $codeCoverageMonitor,
     * @param HtmlReport   $codeCoverageReporter,
     * @param string[]     $config
     */
    public function __construct(
        CodeCoverage $codeCoverageMonitor,
        HtmlReport $codeCoverageReporter,
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
