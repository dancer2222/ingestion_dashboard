<?php
/**
 * Created by PhpStorm.
 * User: dancer
 * Date: 03.07.18
 * Time: 19:02
 */

namespace Ingestion\BlackList;

use Exception;

/**
 * Class RequestMedia
 * @package Ingestion\BlackList
 */
class RequestMedia
{
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
    public function getIdsByAuthor($medias, $mediaType, $action,  $authorId, $command, $oppositeCommand)
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

        $classNameByAuthorName = $this->getClassNameByAuthorName($mediaType);

        $reflectionMethodSet = new \ReflectionMethod($classNameByAuthorName, 'setStatus');
        $reflectionMethodSet->invoke(new $classNameByAuthorName(), $authorId, $sts);

        return $ids;
    }

    /**
     * @param $model
     * @param $id
     * @return array
     * @throws Exception
     * @throws \ReflectionException
     */
    public function useBlackListByAuthor($model, $id)
    {
        $modelName = ucfirst(str_replace('_', '', $model));
        $className = "App\Models\\" . $modelName . 'author';

        $reflectionMethod = new \ReflectionMethod($className, 'getIdByAuthorId');
        $idAuthor = $reflectionMethod->invoke(new $className(), $id);

        if ($idAuthor->isEmpty()) {
            throw new Exception( 'This author id: ' . $id . ' not found in database');
        }

        $idAuthor = $idAuthor->toArray();

        return  $this->getInfo($idAuthor, "App\Models\\" . $modelName);
    }

    /**
     * @param $model
     * @param $id
     * @return mixed
     */
    public static function getAuthorName($model, $id)
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
    private function getInfo($idAuthor, $classNameSecond)
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
    private function getClassNameByAuthorName($mediaType)
    {
        if ($mediaType == 'book') {
            $classNameByAuthorName = "App\Models\Author";
        } else {
            $classNameByAuthorName = "App\Models\Author{$mediaType}";
        }

        return $classNameByAuthorName;
    }
}