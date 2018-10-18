<?php

namespace Ingestion\Exports\Csv;

use App\Models\Licensor;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

/**
 * Class LicensorsContent
 * @package Ingestion\Exports\Csv
 */
class LicensorsContent implements FromQuery, WithHeadings, WithColumnFormatting, ShouldAutoSize
{
    use Exportable;

    /**
     * @var Licensor
     */
    private $licensor;

    /**
     * @var Model
     */
    private $contentModel;

    /**
     * @var
     */
    private $headers;

    /**
     * LicensorsContent constructor.
     * @param Licensor $licensor
     * @param Model $contentModel
     * @param array $headers
     */
    public function __construct(Licensor $licensor, Model $contentModel, array $headers = [])
    {
        $this->licensor = $licensor;
        $this->contentModel = $contentModel;
        $this->headers = $headers;
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        $query = $this->contentModel->newQuery();

        if ($this->headers) {
            $query->select($this->headers);
        }

        return $query->where('licensor_id', $this->licensor->id);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
