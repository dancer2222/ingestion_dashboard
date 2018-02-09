<?php

namespace Ingestion\Search;


/**
 * Class Normalize
 * @package Ingestion\Search
 */
class Normalize
{
    /**
     * @param $licensorName
     * @return mixed
     */
    public static function normalizeBucketName($licensorName)
    {
        $providers = [
            'Aenetworks'         => 'aenetworks',
            'Imira'              => 'imira',
            'Brainstorm Media'   => 'brainmedia',
            'EntertainmentOne'   => 'eone',
            '9StoryMedia'        => '9storymedia',
            'Baker'              => 'baker',
            'BBC'                => 'bbc',
            'BrainStormMedia'    => 'brainmedia',
            'Corus'              => 'corus',
            'DeMarque'           => 'demarque',
            'DHXMedia'           => 'dhxmedia',
            'Draft2Digital'      => 'draft2digital',
            'DynamiteComics'     => 'dynamitecomics',
            'Firebrand'          => 'Firebrand',
            'Nelvana'            => 'corus',
            'Harlequin'          => 'Harlequin',
            'HarlequinGermany'   => 'Harlequin-Germany',
            'HarlequinIberica'   => 'harl-iberica',
            'HarperCollins'      => 'harper-collins-us',
            'HarperCollinsUK'    => 'harper-collins-us',
            'ThomasNelson'       => 'harper-collins-us/Thomas_Nelson',
            'GrupoNelson'        => 'harper-collins-us/Grupo_Nelson',
            'hasbro'             => 'hasbro',
            'IDW'                => 'idwpub',
            'IPG'                => 'IPG',
            'JoMedia'            => 'JoMedia',
            'NationalGeographic' => 'nationalgeographic',
            'Palatium'           => 'palatium',
            'Parkstone'          => 'parkstone',
            'pickatale'          => 'pickatale',
            'Pubdrive'           => 'pubdrive',
            'RedWheelWeiser'     => 'rwwbooks',
            'SandrewMetronome'   => 'sandrewmetronome',
            'Scanbox'            => 'scanbox',
            'Screenmedia'        => 'screenmedia',
            'SimonAndSchuster'   => 'simonschuster',
            'StreetLib'          => 'streetlib',
            'TheOrchard'         => 'theorchard',
            'TwinSisters'        => 'twinsisters',
            'UnderTheMilkyWay'   => 'underthemilkyway',
            'Vearsa'             => 'vearsa',
        ];

        foreach ($providers as $provider => $value) {

            if (mb_strtolower($provider) == mb_strtolower($licensorName)) {
                return $value;
                break;
            }
        }
    }
}