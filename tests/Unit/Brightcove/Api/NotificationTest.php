<?php

namespace Tests\Unit\Brightcove\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NotificationTest extends TestCase
{
    /**
     * Provide the various dataset to call our API notifications
     * DatasetExample = [
     *  [array dataset], http status, [array response], string of status in database,
     * ]
     *
     * @return array
     */
    public function dataJsonProvider()
    {
        return [
            'Correct data' => [
                [
                    "action" => "CREATE",
                    "status" => "SUCCESS",
                    "entityType" => "DIGITAL_MASTER",
                    "videoId" => "5444872379001",
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
                [], 403, null, '',
            ],
            'Wrong data' => [
                [
                    "action" => "CREATE",
                    "status" => "SUCCESSS",
                    "entityType" => "DIGITAL_MASTER",
                    "videoId" => "5444872379001",
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
                    "videoId" => "5444872379001",
                    "entity" => "5444872379001",
                    "accountId" => "267879498700",
                    "version" => "1",
                    "jobId" => "699db2e5-aeb7-4765-a4a7-2cc68c7360bd",
                ],
                403,
                null,
                'failed'
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
    public function testStatusAndJsonResponse(array $data, int $httpStatus, $responseData = null, string $statusInDb)
    {
        $response = $this->json('post', '/api/brightcove/notifications', $data)
            ->assertStatus($httpStatus);

        if ($responseData) {
            $response->assertJsonStructure($responseData);
        }

        if ($httpStatus == 201) {
            $this->ifBrightcoveVideoUpdate($data, $statusInDb);
        }
    }

    /**
     * @param array $data
     * @param string $status
     */
    public function ifBrightcoveVideoUpdate(array $data, string $status)
    {
        $this->assertDatabaseHas('brightcove', [
            'brightcove_id' => $data['videoId'],
            'status' => $status,
        ]);
    }
}
