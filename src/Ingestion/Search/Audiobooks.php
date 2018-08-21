<?php

namespace Ingestion\Search;

use App\Models\Audiobook;
use App\Models\AudiobookBlackList;
use App\Models\AudiobookProduct;
use App\Models\FailedItems;
use App\Models\Licensor;
use App\Models\ProductAudioBook;
use App\Models\QaBatch;
use App\Models\DataSourceProvider;
use Exception;

/**
 * Class Audiobooks
 * @package Ingestion\Reports
 */
class Audiobooks extends MediaTypeAbstract
{
    /**
     * @param $id
     * @param string $mediaTypeTitle
     * @param string $country_code
     * @param string $mediaGeoRestrictGetMediaType
     * @return array
     * @throws \Exception
     */
    public function searchInfoById(
        $id,
        string $mediaTypeTitle,
        $country_code,
        string $mediaGeoRestrictGetMediaType
    ): array {
        $qaBatches = new QaBatch();
        $licensor = new Licensor();
        $info = new Audiobook();

        $info = $info->getInfoById($id);
        $info = $this->toArray($info, $id, $mediaTypeTitle);

        $productAudioBook = new AudiobookProduct();
        $products = $productAudioBook->getInfoById($id)->toArray();

        $productInfo = [];
        $productAudiobook = new ProductAudioBook();

        try {
            foreach ($products as $product) {
                $productInfo [$product['product_id']] = $productAudiobook->getInfoByProductId($product['product_id'])[0]->toArray();
            }
        } catch (Exception $exception) {
            $productInfo = [];
        }

        $blackList = AudiobookBlackList::find($id);

        if (null == $blackList) {
            $blackListStatus = '';
        } else {
            $blackListStatus = $blackList->status;
        }

        //all info by batch_id
        $batchInfo = $qaBatches->getAllByBatchId($info['batch_id']);

        if ($licensor->getNameLicensorById($info['licensor_id'])) {
            $licensorName = $licensor->getNameLicensorById($info['licensor_id'])->name;
        }

        $idLink = substr($id, -6);
        $imageUrl = config('main.links.image') . 'audiobook/findaway/square/' . $idLink . '.jpg';

        $dataSourceProvider = new DataSourceProvider();

        if ($dataSourceProvider->getDataSourceProviderName($info['data_source_provider_id'])) {
            $providerName = $dataSourceProvider->getDataSourceProviderName($info['data_source_provider_id'])->name;
        }

        if ($batchInfo != null) {
            $failedItems = new FailedItems();
            $failedItems = $failedItems->getFailedItems($info['data_origin_id']);
        } else {
            $failedItems = null;
        }

        $result = [
            'id'                           => $id,
            'country_code'                 => $country_code,
            'mediaTypeTitle'               => $mediaTypeTitle,
            'batchInfo'                    => $batchInfo,
            'licensorName'                 => $licensorName,
            'info'                         => $info,
            'providerName'                 => $providerName,
            'imageUrl'                     => $imageUrl,
            'mediaGeoRestrictGetMediaType' => $mediaGeoRestrictGetMediaType,
            'messages'                     => $failedItems,
            'blackListStatus'              => $blackListStatus,
            'products'                     => $products,
            'productInfo'                  => $productInfo
        ];

        return $result;
    }
}