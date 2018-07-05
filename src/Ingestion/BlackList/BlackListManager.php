<?php

namespace Ingestion\BlackList;

use Exception;

/**
 * Class BlackListManager
 * @package Ingestion\BlackList
 */
class BlackListManager
{
    /**
     * @var
     */
    private $id;
    /**
     * @var string
     */
    private $command;

    /**
     * @var string
     */
    private $dataType;

    /**
     * @var string
     */
    private $mediaTypeFromRequest;

    /**
     * BlackListManager constructor.
     * @param string $id
     * @param string $command
     * @param string $dataType
     * @param string $mediaType
     */
    public function __construct(string $id, string $command, string $dataType, string $mediaType)
    {
        $this->id = $id;
        $this->command = $command;
        $this->dataType = $dataType;
        $this->mediaTypeFromRequest = $mediaType;
    }

    /**
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }
    /**
     * @return string
     */
    public function getDataType() : string
    {
        return $this->dataType;
    }

    /**
     * @return string
     */
    public function getCommand() : string
    {
        return $this->command;
    }

    /**
     * @return string
     */
    public function getMediaTypeFromRequest() : string
    {
        return $this->mediaTypeFromRequest;
    }

    /**
     * @return string
     */
    public function getMediaTypeExceptLastSymbol() : string
    {
        return substr($this->mediaTypeFromRequest, 0, -1);
    }
    /**
     * @return string
     */
    public function getMediaType() : string
    {
        return str_replace('_', '', $this->getMediaTypeExceptLastSymbol());
    }

    /**
     * @return string
     */
    public function getModel() : string
    {
        return ucfirst($this->getMediaType());
    }

    /**
     * @param $ids
     * @param $oppositeCommand
     * @param $indexation
     * @return array
     * @throws \ReflectionException
     */
    public function addIdsToBlackList($ids, $oppositeCommand, $indexation) : array
    {
        $unHandledIds = [];
        $handledIds = [];

        foreach ($ids as $id) {
            $className = "App\Models\\" . $this->getModel();
            $reflectionMethod = new \ReflectionMethod($className, 'getInfoById');

            if ($reflectionMethod->invoke(new $className(), $id, $this->getCommand())->isEmpty()) {
                $unHandledIds[] = $id;

                continue;
            };

            $classNameBlack = "App\Models\\" . $this->getModel() . "BlackList";

            $classNameBlack::updateOrCreate([
                    $this->getMediaTypeExceptLastSymbol() . '_id' => (int) $id
            ], [
                    'status' => $this->getCommand()
            ]);

            $reflectionMethodSet = new \ReflectionMethod($className, 'setStatus');
            $reflectionMethodSet->invoke(new $className(), $id, $oppositeCommand);

            $indexation->push('updateSingle', str_replace('_', '', $this->getMediaTypeFromRequest()), $id);
            $handledIds[] = $id;

            continue;
        }

        $allIds = [
            'unHandledIds' => $unHandledIds,
            'handledIds' => $handledIds
        ];

        return $allIds;
    }

    /**
     * @param $medias
     * @param $mediaType
     * @param $action
     * @param $authorId
     * @param $command
     * @param $oppositeCommand
     * @return array
     * @throws \ReflectionException
     */
    public function getIdsByAuthorSetStatusAuthor($medias, $mediaType, $action,  $authorId, $command, $oppositeCommand) :array
    {
        $ids = [];
        $sts = $oppositeCommand;

        foreach ($medias as $media => &$item) {
            if (isset($item['checked'])) {
                $ids[] = $item['id'];
            } elseif (!isset($item['checked']) && $action === 'add') {
                $sts = $command;
            } else {
                $sts = $oppositeCommand;
            }
        }

        $this->setStatusAuthor($mediaType, $authorId, $sts);

        return $ids;
    }

    /**
     * @param $mediaType
     * @param $authorId
     * @param $sts
     * @throws \ReflectionException
     */
    private function setStatusAuthor($mediaType, $authorId, $sts)
    {
        $classNameByAuthorName = $this->getClassNameByAuthorName($mediaType);

        $reflectionMethodSet = new \ReflectionMethod($classNameByAuthorName, 'setStatus');
        $reflectionMethodSet->invoke(new $classNameByAuthorName(), $authorId, $sts);
    }

    /**
     * @param $medias
     * @return array
     */
    public function getIdsById($medias) : array
    {
        $ids = [];

        foreach ($medias as $media => $item) {
            if (isset($item['checked'])) {
                $ids[] = $item['id'];
            }

            continue;
        }

        return $ids;
    }

    /**
     * @param $model
     * @param $id
     * @return array
     * @throws Exception
     * @throws \ReflectionException
     */
    public function getInfoByAuthorId($model, $id) : array
    {
        $modelName = ucfirst(str_replace('_', '', $model));
        $className = "App\Models\\" . $modelName . 'author';

        $reflectionMethod = new \ReflectionMethod($className, 'getIdByAuthorId');
        $idAuthor = $reflectionMethod->invoke(new $className(), $id);

        if ($idAuthor->isEmpty()) {
            throw new Exception( 'This author id: ' . $id . ' not found in database');
        }

        $idAuthor = $idAuthor->toArray();

        return  $this->getInfoAuthorByAuthorId($idAuthor, "App\Models\\" . $modelName);
    }

    /**
     * @param $ids
     * @param $model
     * @return array
     * @throws \ReflectionException
     */
    public function getInfoById($ids, $model) : array
    {
        $ids = explode(',', str_replace(' ', '', $ids));
        $info = [];

        foreach ($ids as $id) {

            $className = "App\Models\\" . $model;
            $reflectionMethod = new \ReflectionMethod($className, 'getInfoById');
            $result = $reflectionMethod->invoke(new $className(), $id)->toArray()[0];

            $info [] = [
                    'id'    => $result['id'],
                    'title' => $result['title'],
            ];

            continue;
        }

        return $info;
    }

    /**
     * @param $model
     * @param $id
     * @return mixed
     */
    public static function getAuthorName($model, $id) : string
    {
        if ($model == 'book') {
            $classNameByAuthorName = "App\Models\Author";
        } else {
            $classNameByAuthorName = "App\Models\\" . 'Author' . str_replace('_', '', $model);
        }

        return $classNameByAuthorName::find($id)->name;
    }

    /**
     * @param $idAuthor
     * @param $classNameSecond
     * @return array
     */
    private function getInfoAuthorByAuthorId($idAuthor, $classNameSecond) : array
    {
        $info = [];

        foreach ($idAuthor as $itemInfo) {
            foreach ($itemInfo as $value) {
                if (!$mediaCollection = $classNameSecond::find($value)) {
                    continue;
                }

                $info[] = [
                        'id'    => $mediaCollection->id,
                        'title' => $mediaCollection->title
                ];
            }
        }

        return $info;
    }

    /**
     * @param $mediaType
     * @return string
     */
    private function getClassNameByAuthorName($mediaType) : string
    {
        if ($mediaType == 'book') {
            $classNameByAuthorName = "App\Models\Author";
        } else {
            $classNameByAuthorName = "App\Models\Author{$mediaType}";
        }

        return $classNameByAuthorName;
    }
}