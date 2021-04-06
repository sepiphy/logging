<?php declare(strict_types=1);

/*
 * This file is part of the Sepiphy package.
 *
 * (c) Quynh Xuan Nguyen <seriquynh@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sepiphy\Logging;

use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\AbstractProcessingHandler;
use SunAsterisk\Chatwork\Chatwork as ChatworkClient;
use SunAsterisk\Chatwork\Helpers\Message as ChatworkMessage;

/**
 * @author Quynh Xuan Nguyen <seriquynh@gmail.com>
 */
class ChatworkHandler extends AbstractProcessingHandler
{
    /**
     * @var ChatworkClient
     */
    protected $chatworkClient;

    /**
     * @var string
     */
    protected $roomId;

    /**
     * Constructor
     *
     * @param string $apiKey
     * @param int $roomId
     * @return void
     */
    public function __construct(string $apiKey, int $roomId)
    {
        parent::__construct();

        $this->chatworkClient = ChatworkClient::withAPIToken($apiKey);
        $this->roomId = $roomId;
    }

    /**
     * {@inheritdoc}
     */
    public function write(array $record): void
    {
        $message = (string) (new ChatworkMessage())->code($this->getFormatter()->format($record));

        $this->chatworkClient->room($this->roomId)->messages()->create($message);
    }

    /**
     * @return $this
     */
    public function setChatworkClient(ChatworkClient $chatworkClient)
    {
        $this->chatworkClient = $chatworkClient;

        return $this;
    }

    /**
     * @return ChatworkClient
     */
    public function getChatworkClient()
    {
        return $this->chatworkClient;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new LineFormatter(null, null, true, true);
    }
}
