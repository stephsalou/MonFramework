<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 15/02/2020
 * Time: 16:23
 */

namespace Tests\Framework\Session;

use App\Framework\Session\ArraySession;
use App\Framework\Session\FlashService;
use PHPUnit\Framework\TestCase;

class FlashServiceTest extends TestCase
{

    /**
     * @var ArraySession
     */
    private $session;

    /**
     * @var FlashService
     */
    private $flashService;

    public function setUp(): void
    {
        $this->session = new ArraySession();
        $this->flashService = new FlashService($this->session);
    }

    public function testDeleteAfterGettingIt(): void
    {
        $this->flashService->success('bravo');
        $this->assertEquals('bravo', $this->flashService->get('success'));
        $this->assertNull($this->flashService->get('flash'));
        $this->assertEquals('bravo', $this->flashService->get('success'));
        $this->assertEquals('bravo', $this->flashService->get('success'));
    }
}
