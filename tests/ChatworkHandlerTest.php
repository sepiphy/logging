<?php declare(strict_types=1);

/*
 * This file is part of the Sepiphy package.
 *
 * (c) Quynh Xuan Nguyen <seriquynh@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Sepiphy\Logging;

use Assert;
use Mockery as m;
use Sepiphy\Logging\ChatworkHandler;
use SunAsterisk\Chatwork\Chatwork as ChatworkClient;
use PHPUnit\Framework\TestCase;

/**
 * @author Quynh Xuan Nguyen <seriquynh@gmail.com>
 */
class ChatworkHandlerTest extends TestCase
{
    public function testWrite()
    {
        $chatworkHandler = new ChatworkHandler($apiKey = 'my-api-key', $roomId = 'my-room-id');

        /** @var ChatworkClient $chatworkClient */
        $chatworkClient = m::mock(ChatworkClient::class);
        /** @phpstan-ignore-next-line */
        $chatworkClient->shouldReceive('room')->once()->with($roomId)->andReturn(new class() {
            public function messages()
            {
                return $this;
            }

            public function create($message)
            {
                Assert::assertTrue(strpos((string) $message, 'This is a log message.') !== false);
            }
        });


        $chatworkHandler->setChatworkClient($chatworkClient);

        $chatworkHandler->write([
            'message' => 'This is a log message.',
            'level' => 1,
            'level_name' => '',
            'context' => [],
            'channel' => '',
            'datetime' => new \DateTimeImmutable(),
            'extra' => [],
        ]);
    }
}
