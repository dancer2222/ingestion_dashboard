<?php

namespace App\Http\Controllers\Licensors;

use App\Models\Licensor;
use App\Models\Audiobook;
use App\Models\Book;
use App\Models\Movie;
use App\Models\Album;
use App\Models\Game;
use App\Models\Software;
use App\Http\Controllers\Controller;
use Ingestion\Exports\Csv\LicensorsContent;

class LicensorsController extends Controller
{
    const CONTENT_MODELS_MAPPING = [
        'audiobooks' => Audiobook::class,
        'books' => Book::class,
        'movies' => Movie::class,
        'music' => Album::class,
        'games' => Game::class,
        'software' => Software::class,
    ];

    /**
     * Display blank form.
     *
     * @param Licensor $licensor
     * @return \Illuminate\Http\Response
     */
    public function index(Licensor $licensor)
    {
        $data = [];
        $isList = request()->has('list');
        $name = request()->get('name');
        $media_types = request()->input('media_type');
        $status = request()->input('status');

        if ($media_types) {
            $licensor = $licensor->whereIn('media_type', $media_types);
        }

        if ($status) {
            $licensor = $licensor->whereIn('status', $status);
        }

        if ($name) {
            if (is_numeric($name) && ctype_digit($name)) {
                $licensor = $licensor->where('id', $name);
            } else {
                $licensor = $licensor->where('name', 'like', "%$name%");
            }
        }

        if ($isList || $name || $media_types || $status) {
            $data['licensors'] = $licensor->get();
        }

        return view('template_v2.misc.licensors.index', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param Licensor $licensor
     * @return \Illuminate\Http\Response
     */
    public function show($id, Licensor $licensor)
    {
        $errors = [];
        $licensor = $licensor->find($id);

        if (!$licensor) {
            $errors[] = "Didn't find licensor with ID: $id";
        }

        if (!isset(self::CONTENT_MODELS_MAPPING[$licensor->media_type])) {
            $errors[] = 'No contents found.';
        }

        if ($errors) {
            return view('template_v2.misc.licensors.index')->withErrors($errors);
        }

        $contentModel = self::CONTENT_MODELS_MAPPING[$licensor->media_type];
        $licensorContentItems = $contentModel::where('licensor_id', $licensor->id)->paginate(15);

        return view('template_v2.misc.licensors.index', [
            'licensor' => $licensor,
            'licensorContentItems' => $licensorContentItems,
        ]);
    }

    /**
     * @param $id
     * @param Licensor $licensor
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportContent($id, Licensor $licensor)
    {
        try {
            $licensor = $licensor->find($id);

            $licensorContentModel = self::CONTENT_MODELS_MAPPING[$licensor->media_type];
            $licensorContentModel = new $licensorContentModel;

            $nowDate = now()->format('Y_m_d');
            $licensorName = str_replace(' ', '_', $licensor->name);
            $filename = "{$licensorName}_{$licensor->media_type}_{$nowDate}.csv";

            return (new LicensorsContent($licensor, $licensorContentModel, ['id', 'title']))
                ->download($filename, \Maatwebsite\Excel\Excel::CSV);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return back()->withErrors('Something went wrong. The error message was written to the log.');
        }
    }
}
