<?php

namespace App\Http\Controllers\TestsContent;

use App\Http\Controllers\Controller;
use App\Models\FailedItems;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Isbn\Isbn;
use yidas\phpSpreadsheet\Helper;

/**
 * Class TestsController
 * @package App\Http\Controllers\TestsContent
 */
class TestsController extends Controller
{
    /**
     * @var array
     */
    private $isbns = [];

    /**
     * @var
     */
    private $date;

    /**
     * @var
     */
    private $isbnHandler;
    /**
     * @var
     */
    private $filepath, $variableStatusItem;

    /**
     * @var Helper
     */
    private $helperXLSX;

    /**
     * TestsController constructor.
     */
    public function __construct()
    {
        $this->date = new Carbon();
        $this->helperXLSX = new Helper();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexBooks()
    {
        return view('testsContent.booksTest');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getInfoBooks(Request $request)
    {
        $this->isbnHandler = new Isbn();

        if ($request->has('data')) {
            $this->getIsbnFromForm($request->data);
        }

        if ($request->has('file')) {
            $this->getIsbnFromFile($request->file);
        }

        if (is_null($this->isbns)) {
            return redirect()->back()->withErrors('Not Found ISBN');
        }

        $this->isbns = array_unique($this->isbns);
        $this->getInfoFromDB($request->mediaType);
        $this->createXlSX($this->variableStatusItem['notFoundIsbn']);

        return view('testsContent.showBooks',
            ['filepath' => $this->filepath, 'variableStatusItem' => $this->variableStatusItem]);
    }

    /**
     * @param $data
     */
    private function getIsbnFromForm($data)
    {
        $patterns = [
            '/(\s+)/',
            '/(\R+)/',
            '/(\r|\n)/',
            '/(,+)/',
        ];
        $data = preg_replace($patterns, ',', $data);
        $data = trim($data, ' ,\r\n');
        $datas = explode(',', $data);

        foreach ($datas as $data) {
            $data = str_replace('`', '', $data);
            if ($this->isbnHandler->validation->isbn($data)) {
                $this->isbns [] = $data;
            }
        }
    }

    /**
     * @param $data
     * @return \Illuminate\Http\RedirectResponse
     */
    private function getIsbnFromFile($data)
    {
        $patterns = [
            '/(\s+)/',
            '/(\R+)/',
            '/(\r|\n)/',
            '/(,+)/',
            '`',
        ];

        try {
            $data = excelToArray($data->getRealPath());
        } catch (Exception $exception) {
            return redirect()->back()->withErrors($exception);
        }

        foreach ($data['items'] as $item) {
            foreach ($item as $value) {
                $data = str_replace($patterns, '', $value);

                if ($this->isbnHandler->validation->isbn($data)) {
                    $this->isbns [] = $data;
                }
            }
        }
    }

    /**
     * @param $mediaType
     * @return bool
     */
    private function getInfoFromDB($mediaType)
    {
        $contentModelName = self::CONTENT_MODELS_MAPPING[$mediaType];
        $contentModel = new $contentModelName;
        $data = $contentModel->getInfoByIsbns($this->isbns);

        foreach ($this->isbns as $key => $isbn) {
            if (!$data->where('isbn', $isbn)->all()) {
                $this->variableStatusItem['notFoundIsbn'][][] = $isbn;
            }
        }

        $failedItems = new FailedItems();
        $completeInfo = [];

        foreach ($data as $item) {
            $result = $failedItems->getActiveFailedItems($item->data_origin_id);

            if (is_array($result)) {
                $completeInfo [] = [
                    'id'              => ' ' . $item->id,
                    'title'           => $item->title,
                    'name'            => $item->auth_name,
                    'isbn'            => $item->isbn,
                    'ma_release_date' => $item->ma_release_date,
                    'status'          => $item->status,
                    'level'           => $result[0]['level'],
                    'reason'          => $result[0]['reason'],
                    'time'            => $result[0]['time'],
                    'error_code'      => $result[0]['error_code'],
                    'batch_id'        => $result[0]['batch_id'],
                ];
            } else {
                $completeInfo [] = [
                    'id'              => ' ' . $item->id,
                    'title'           => $item->title,
                    'name'            => $item->auth_name,
                    'isbn'            => $item->isbn,
                    'ma_release_date' => $item->ma_release_date,
                    'status'          => $item->status,
                ];
            }
        }

        foreach ($completeInfo as $item) {
            if ($this->date->format('Y-m-d') < $item['ma_release_date']) {
                $this->variableStatusItem['notNowReleaseDate'] [] = $item;
            } else {
                if ('active' === $item['status']) {
                    $this->variableStatusItem['activeItem'] [] = $item;
                } else {
                    if (!isset($item['level'])) {
                        $this->variableStatusItem['inactiveNotHaveFailedItem'] [] = $item;
                    } else {
                        if ('warning' === $item['level']) {
                            $this->variableStatusItem['levelWarningItem'] [] = $item;
                        } else {
                            $this->variableStatusItem['levelCriticalItem'] [] = $item;
                        }
                    }
                }
            }
        }

        return true;
    }

    /**
     * Created all xlsx document
     */
    private function createXlSX()
    {
        $columnTitle = [
            'id', 'title', 'author_name', 'isbn', 'ma_release_date', 'status book',
            'error level', 'reason', 'time', 'error_code', 'batch_id'
        ];

        $this->filepath['filepathNotNowReleaseDate'] = 'Future_release_date_' . ($this->date->format('d-m-Y'));

        if (!isset($this->variableStatusItem['notNowReleaseDate'])) {
            $this->variableStatusItem['notNowReleaseDate'] = [[0 => 'Empty']];
        }

        $this->helperXLSX->newSpreadsheet()
            ->addRow($columnTitle)->setStyle(['font' => ['bold' => true]])->setAutoSize()
            ->addRows($this->variableStatusItem['notNowReleaseDate'])
            ->save(public_path('tmp/download/' . $this->filepath['filepathNotNowReleaseDate']));

        $this->filepath['filepathNotFoundIsbn'] = 'Not_found_ISBN_' . $this->date->format('d-m-Y');

        if (!isset($this->variableStatusItem['notFoundIsbn'])) {
            $this->variableStatusItem['notFoundIsbn'] = [[0 => 'Empty']];
        }

        $this->helperXLSX->newSpreadsheet()
            ->addRow([
                'isbn'
            ])->setStyle(['font' => ['bold' => true]])->setAutoSize()
            ->addRows($this->variableStatusItem['notFoundIsbn'])
            ->save(public_path('tmp/download/' . $this->filepath['filepathNotFoundIsbn']));

        $this->filepath['filepathActiveItem'] = 'Active_items_' . ($this->date->format('d-m-Y'));

        if (!isset($this->variableStatusItem['activeItem'])) {
            $this->variableStatusItem['activeItem'] = [[0 => 'Empty']];
        }

        $this->helperXLSX->newSpreadsheet()
            ->addRow($columnTitle)->setStyle(['font' => ['bold' => true]])->setAutoSize()
            ->addRows($this->variableStatusItem['activeItem'])
            ->save(public_path('tmp/download/' . $this->filepath['filepathActiveItem']));

        $this->filepath['filepathLevelWarningItem'] = 'Level_warning_failed_items_' . ($this->date->format('d-m-Y'));

        if (!isset($this->variableStatusItem['levelWarningItem'])) {
            $this->variableStatusItem['levelWarningItem'] = [[0 => 'Empty']];
        }

        $this->helperXLSX->newSpreadsheet()
            ->addRow($columnTitle)->setStyle(['font' => ['bold' => true]])->setAutoSize()
            ->addRows($this->variableStatusItem['levelWarningItem'])
            ->save(public_path('tmp/download/' . $this->filepath['filepathLevelWarningItem']));

        $this->filepath['filepathLevelCriticalItem'] = 'Level_critical_failedItems_' . ($this->date->format('d-m-Y'));

        if (!isset($this->variableStatusItem['levelCriticalItem'])) {
            $this->variableStatusItem['levelCriticalItem'] = [[0 => 'Empty']];
        }

        $this->helperXLSX->newSpreadsheet()
            ->addRow($columnTitle)->setStyle(['font' => ['bold' => true]])->setAutoSize()
            ->addRows($this->variableStatusItem['levelCriticalItem'])
            ->save(public_path('tmp/download/' . $this->filepath['filepathLevelCriticalItem']));

        $this->filepath['filepathInactiveNotHaveFailedItem'] = 'Inactive_items_NotHave_failedItems_' . ($this->date->format('d-m-Y'));

        if (!isset($this->variableStatusItem['inactiveNotHaveFailedItem'])) {
            $this->variableStatusItem['inactiveNotHaveFailedItem'] = [[0 => 'Empty']];
        }

        $this->helperXLSX->newSpreadsheet()
            ->addRow($columnTitle)->setStyle(['font' => ['bold' => true]])->setAutoSize()
            ->addRows($this->variableStatusItem['inactiveNotHaveFailedItem'])
            ->save(public_path('tmp/download/' . $this->filepath['filepathInactiveNotHaveFailedItem']));
    }

    /**
     * @param $fileName
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($fileName)
    {
        return response()->download(public_path('tmp/download/' . $fileName . '.xlsx'));
    }

    /**
     * @param Request $request
     */
    public function createFinalXLSX(Request $request)
    {
        $medias = $request->media;

        foreach ($medias as $media => $value) {
            if (!isset($value['checked'])) {
                unset($medias[$media]);
            }
        }

        foreach ($medias as &$media) {
            foreach ($media as $item => $value) {
                if ($item == 'checked') {
                    unset($media[$item]);
                }
            }
        }

        $columnTitle = [
            'id', 'title', 'author_name', 'isbn', 'ma_release_date', 'status book',
            'error level', 'reason', 'time', 'error_code', 'batch_id'
        ];

        $this->helperXLSX->newSpreadsheet()
            ->addRow($columnTitle)->setStyle(['font' => ['bold' => true]])->setAutoSize()
            ->addRows($medias)
            ->output($this->date->format('d-m-Y') . 'Final report');
    }
}
