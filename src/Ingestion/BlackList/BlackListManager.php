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
     * @var array
     */
    public $handledIds;

    /**
     * @var array
     */
    public $unHandledIds;

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
     * @throws \ReflectionException
     */
    public function addIdsToBlackList($ids, $oppositeCommand, $indexation)
    {
        foreach ($ids as $id) {
            $className = "App\Models\\" . $this->getModel();
            $reflectionMethod = new \ReflectionMethod($className, 'getInfoById');

            if ($reflectionMethod->invoke(new $className(), $id, $this->getCommand())->isEmpty()) {
                $this->unHandledIds[] = $id;

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
            $this->handledIds[] = $id;

            continue;
        }
    }

    /**
     * @param $medias
     * @param $oppositeCommand
     * @return array
     * @throws \ReflectionException
     */
    public function getIdsByAuthorSetStatusAuthor($medias, $oppositeCommand) :array
    {
        $ids = [];
        $sts = $oppositeCommand;

        foreach ($medias as $media => &$item) {
            if (isset($item['checked'])) {
                $ids[] = $item['id'];
            } elseif (!isset($item['checked']) && $this->getCommand() === 'add') {
                $sts = $this->getCommand();
            } else {
                $sts = $oppositeCommand;
            }
        }

        $this->setStatusAuthor($sts);

        return $ids;
    }

    /**
     * @param $sts
     * @throws \ReflectionException
     */
    private function setStatusAuthor($sts)
    {
        $classNameByAuthorName = $this->getClassNameByAuthorName($this->getMediaType());

        $reflectionMethodSet = new \ReflectionMethod($classNameByAuthorName, 'setStatus');
        $reflectionMethodSet->invoke(new $classNameByAuthorName(), $this->getId(), $sts);
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
     * @return array
     * @throws Exception
     * @throws \ReflectionException
     */
    public function getInfoByAuthorId() : array
    {
        $modelName = ucfirst(str_replace('_', '', $this->getModel()));
        $className = "App\Models\\" . $modelName . 'author';

        $reflectionMethod = new \ReflectionMethod($className, 'getIdByAuthorId');
        $idAuthor = $reflectionMethod->invoke(new $className(), $this->getId());

        if ($idAuthor->isEmpty()) {
            throw new Exception( 'This author id: ' . $this->getId() . ' not found in database');
        }

        $idAuthor = $idAuthor->toArray();

        return  $this->getInfoAuthorByAuthorId($idAuthor, "App\Models\\" . $modelName);
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getInfoById() : array
    {
        $ids = explode(',', str_replace(' ', '', $this->id));
        $info = [];

        foreach ($ids as $id) {

            $className = "App\Models\\" . $this->getModel();
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
     * @return string
     */
    public function getAuthorName() : string
    {
        if ($this->getMediaType() == 'book') {
            $classNameByAuthorName = "App\Models\Author";
        } else {
            $classNameByAuthorName = "App\Models\\" . 'Author' . $this->getMediaType();
        }

        return $classNameByAuthorName::find($this->id)->name;
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