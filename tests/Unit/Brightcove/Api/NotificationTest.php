<?php

namespace Tests\Unit\Brightcove\Api;

use App\Models\Brightcove;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NotificationTest extends TestCase
{
    /**
     * Provide the various dataset to call our API notifications
     * DatasetExample = [
     *  [array dataset], http status, [array response], string of status in
     * database,
     * ]
     *
     * @return array
     */
    public function dataJsonProvider() {
        $videoId = rand(1000000000000, 10000000000001);

        return [
            'Correct data' => [
                [
                    "action" => "CREATE",
                    "status" => "SUCCESS",
                    "entityType" => "DIGITAL_MASTER",
                    "videoId" => $videoId,
                    "entity" => "5444872379001",
                    "accountId" => "2678794987001",
                    "version" => "1",
                    "jobId" => "699db2e5-aeb7-4765-a4a7-2cc68c7360bd",
                ],
                201,
                ['message'],
                'active',
            ],
            'Without data' => [
                [],
                403,
                NULL,
                '',
            ],
            'Wrong data' => [
                [
                    "action" => "CREATE",
                    "status" => "SUCCESSS",
                    "entityType" => "DIGITAL_MASTER",
                    "videoId" => $videoId,
                    "entity" => "5444872379001",
                    "accountId" => "2678794987001",
                    "version" => "1",
                    "jobId" => "699db2e5-aeb7-4765-a4a7-2cc68c7360bd",
                ],
                400,
                ['message'],
                '',
            ],
            'Wrong account id' => [
                [
                    "action" => "CREATE",
                    "status" => "FAILED",
                    "entityType" => "DIGITAL_MASTER",
                    "videoId" => $videoId,
                    "entity" => "5444872379001",
                    "accountId" => "267879498700",
                    "version" => "1",
                    "jobId" => "699db2e5-aeb7-4765-a4a7-2cc68c7360bd",
                ],
                403,
                NULL,
                'inactive',
            ],
        ];
    }

    /**
     *
     * @param array $data
     * @param int $httpStatus
     * @param array|null $responseData
     * @param string $statusInDb
     *
     * @dataProvider dataJsonProvider
     */
    public function testStatusAndJsonResponse(array $data, int $httpStatus, $responseData = NULL, string $statusInDb) {
        if (isset($data) && isset($data['videoId'])) {
            Brightcove::create([
                'id' => rand(1000000000000, 10000000000001),
                'brightcove_id' => $data['videoId'],
                'status' => 'active',
                'user_id' => 0,
                'created_at' => time(),
                'updated_at' => time(),
                'non_drm_brightcove_id' => $data['videoId'],
            ]);
        }

        $response = $this->json('post', '/api/brightcove/notifications', $data)
            ->assertStatus($httpStatus);

        if ($responseData) {
            $response->assertJsonStructure($responseData);
        }

        if ($httpStatus == 201) {
            $this->ifBrightcoveVideoUpdated($data, $statusInDb);
        }

        Brightcove::whereBrightcoveId(isset($data['videoId']) ? $data['videoId'] : '')->delete();
    }

    /**
     * @param array $data
     * @param string $status
     */
    public function ifBrightcoveVideoUpdated(array $data, string $status) {
        $this->assertDatabaseHas('brightcove', [
            'brightcove_id' => $data['videoId'],
            'status' => $status,
        ]);
    }
}
