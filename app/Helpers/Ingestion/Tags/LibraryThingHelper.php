<?php

namespace App\Helpers\Ingestion\Tags;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\GuzzleException;


class LibraryThingHelper
{
    const CREDENTIALS = ['green', 'beluga'];
    const BASE_URL = 'http://www.librarything.com/files/green';

    private $guzzle;
    private $configDir;
    private $configFile;
    private $config = [];

    private $feeds = [
        'works_to_isbn_current.xml.bz2',
//        'worktotags_current.xml.bz2',
    ];

    public function __construct(Guzzle $guzzle)
    {
        $this->guzzle = $guzzle;
        $this->configDir = sys_get_temp_dir() . '/librarything';
        $this->configFile = $this->configDir . '/config';

        $this->makeDataFolder();

        if (file_exists($this->configFile) && is_file($this->configFile)) {
            $this->config = unserialize(file_get_contents($this->configFile), ['allowed_classes' => true]);
        }
    }

    public function makeDataFolder()
    {
        if (!file_exists($this->configDir) && !is_dir($this->configDir)) {
            if (!mkdir($concurrentDirectory = $this->configDir, 0777) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
        }
    }

    /**
     * @return array
     */
    public function getFeeds(): array
    {
        return $this->feeds;
    }

    /**
     * @return array
     */
    public function checkForUpdates(): array
    {
        if (!$this->config) {
            return $this->feeds;
        }

        $filenames = [];
        $currentDate = new \DateTime();

        foreach ($this->feeds as $fileName) {
            if (!isset($this->config[$fileName])) {
                $filenames[] = $fileName;

                continue;
            }

            $result = $this->guzzle->head(self::BASE_URL . "/$fileName", [
                'auth' => self::CREDENTIALS,
            ]);

            if ($result->getStatusCode() !== 200 || !$result->hasHeader('Last-Modified')) {
                continue;
            }

            $remoteFileDateModification = new \DateTime($result->getHeader('Last-Modified')[0] ?: $currentDate);

            if ($this->config[$fileName] < $remoteFileDateModification) {
                $filenames[] = $fileName;
            }
        }

        return $filenames;
    }

    /**
     * TODO: Consider to remove this method
     * @return array
     */
    public function checkForLocalFeeds(): array
    {
        $notParsedFeeds = [];

        foreach ($this->feeds as $filename) {
            $filePath = "$this->configDir/$filename";

            if (!file_exists($filePath)) {
                continue;
            }

            $notParsedFeeds[] = $filePath;
        }

        return $notParsedFeeds;
    }

    /**
     * @param array $filenames
     * @param $progress
     * @return array
     */
    public function download(array $filenames, $progress = null): array
    {
        $downloadedFiles = [];
        $options = [
            'auth' => self::CREDENTIALS,
        ];

        if ($progress && \is_callable($progress)) {
            $options['progress'] = $progress;
        }

        foreach ($filenames as $filename) {
            $localFilePath = "$this->configDir/$filename";
            $options['sink'] = $localFilePath;

            try {
                $this->guzzle->request('get', self::BASE_URL . "/$filename", $options);
            } catch (GuzzleException $e) {
                unlink($localFilePath);
                continue;
            }

            if (file_exists($localFilePath)) {
                $downloadedFiles[] = $filename;
            }
        }

        return $downloadedFiles;
    }

    /**
     * @param array $filesToDecompress
     * @return array Files were decompressed
     */
    public function decompressBz2Files(array $filesToDecompress): array
    {
        $decompressedFiles = [];

        foreach ($filesToDecompress as $filename) {
            exec("bzip2 -d $this->configDir/$filename");

            $decompressedFilePath = rtrim($filename, '.bz2');

            if (file_exists($decompressedFilePath)) {
                $decompressedFiles[] = $decompressedFilePath;
            }
        }

        return $decompressedFiles;
    }

    /**
     * Save last modification dates into file; Look at $this->localFileLastDownloadDate
     *
     * @param array $files
     */
    public function saveLastModificationDate(array $files)
    {
        $datesToSave = [];

        foreach ($files as $fileName) {
            $modDate = filemtime("$this->configDir/$fileName");

            $datesToSave[$fileName] = new \DateTime(date('Y-m-d H:i:s ', $modDate));
        }

        if ($datesToSave) {
            file_put_contents($this->configFile, serialize($datesToSave));
        }
    }
}