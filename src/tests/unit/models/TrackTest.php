<?php
namespace tests\unit\models;

use Yii;
use app\models\Track;

class TrackTest extends \Codeception\Test\Unit
{
    public function testCreateTrack()
    {
        $track = new Track();
        $track->track_number = 'ABC123';
        $track->status = Track::STATUS_NEW;
        $this->assertTrue($track->save(), 'Failed to save new track');

        // Проверка получения статуса
        $this->assertEquals('New', $track->getStatusLabel());

        // Проверка isCompleted
        $this->assertFalse($track->isCompleted());

        // Обновление статуса
        $track->status = Track::STATUS_COMPLETED;
        $this->assertTrue($track->save());
        $this->assertTrue($track->isCompleted());
    }

    public function testUniqueTrackNumber()
    {
        $track1 = new Track();
        $track1->track_number = 'UNIQUE123';
        $track1->status = Track::STATUS_NEW;
        $this->assertTrue($track1->save());

        $track2 = new Track();
        $track2->track_number = 'UNIQUE123';
        $this->assertFalse($track2->validate());
    }

    public function testInvalidStatus()
    {
        $track = new Track();
        $track->track_number = 'XYZ789';
        $track->status = 'invalid_status';

        $this->assertFalse($track->validate());
    }
}