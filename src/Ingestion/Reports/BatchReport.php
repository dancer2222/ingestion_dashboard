<?php

namespace Ingestion\Reports;


use App\Models\Album;
use App\Models\Audiobook;
use App\Models\Book;
use App\Models\Movie;
use App\Models\QaBatch;
use App\Models\MediaType;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;
use Mockery\Exception;

/**
 * Class BatchReport
 * @package Ingestion\Reports
 */
class BatchReport
{
    /**
     * @var
     */
    private $batch_id;

    /**
     * BatchReport constructor.
     *
     * @param $batch_id
     */
    public function __construct($batch_id)
    {
        $this->batch_id = $batch_id;
    }

    /**
     * @return \Exception|string
     */
    public function generate()
    {
        try {
            $message = $this->generateBatchList();

            return $message;
        } catch (\Exception $e) {

            return $e;
        }
    }

    /**
     * @return \Exception|string
     */
    private function generateBatchList()
    {
        // get Batch info
        try {
            $qaBatch = new QaBatch();
            $batch_info = $qaBatch->getAllByBatchId($this->batch_id);


            if ($batch_info === null) {
                $message = 'This batch_id [' . $this->batch_id . '] not found in database';

                return $message;
            }
        } catch (\Exception $exception) {

            return $exception;
        }

        // get media types info in batch
        $mediaTypes = new MediaType();
        try {
            $mediaTypeTitle = $mediaTypes->getTitleById($batch_info['media_type_id'])->title;
        } catch (\Exception $exception) {

            return $exception;
        }

        switch ($mediaTypeTitle) {
            case 'movies':
                try {
                    $movie = new Movie();
                    $batch = $movie->getBatchInfoForMovies($this->batch_id);
                } catch (\Exception $exception) {

                    return $exception;
                }
                break;
            case 'books':
                try {
                    $book = new Book();
                    $batch = $book->getBatchInfoForBooks($this->batch_id);
                } catch (\Exception $exception) {

                    return $exception;
                }
                break;
            case 'albums':
                try {

                    $album = new Album();
                    $batch = $album->getBatchInfoForAlbums($this->batch_id);
                } catch (\Exception $exception) {

                    return $exception;
                }
                break;
            case 'audiobooks':
                try {
                    $audioBook = new Audiobook();
                    $batch = $audioBook->getBatchInfoForAudioBooks($this->batch_id);
                } catch (\Exception $exception) {

                    return $exception;
                }
                break;
            default:
                $message = 'This batch_id [' . $this->batch_id . '] not found in database';

                return $message;
        }

        foreach ($batch as &$b) {
            $b->id = $b->id . ' ';
        }

        try {
            $finalBatch = [];
            foreach ($batch as &$item) {
                $item = (array)$item;
                $finalBatch[] = $item;
            }
            array_unshift($finalBatch, array_keys($finalBatch[0]));
        } catch (\Exception $exception) {

            return $exception;
        }

        //create xlsx document
        try {
            Excel::create($this->getReportFileName(), function($excel) use ($finalBatch) {
                $excel->sheet('Report', function($sheet) use ($finalBatch) {
                    $sheet->fromArray($finalBatch, null, 'A1', false, false);
                });
            })->download('xlsx');
            $message = 'Report generate successful';

            return $message;
        } catch (Exception $exception) {

            return $exception;
        }
    }

    /**
     * return the name we want to set to the report file.
     *
     * @return string The name of the file for that report.
     */
    protected function getReportFileName()
    {
        $currentDate = (new DateTime())->format('Y-m-d');

        return $this->batch_id . '_BatchReport_' . $currentDate . '.xls';
    }
}