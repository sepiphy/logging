<?php declare(strict_types=1);

/*
 * This file is part of the sepiphy/phptools package.
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
use SunAsterisk\Chatwork\Chatwork;

/**
 * @author Quynh Xuan Nguyen <seriquynh@gmail.com>
 */
class ChatworkHandler extends AbstractProcessingHandler
{
    /**
     * @var Chatwork
     */
    protected $chatwork;

    /**
     * @var string
     */
    protected $roomId;

    /**
     * Constructor
     *
     * @param string $apiKey
     * @param string $roomId
     * @return void
     */
    public function __construct(string $apiKey, string $roomId)
    {
        parent::__construct();

        $this->chatwork = Chatwork::withAPIToken($apiKey);
        $this->roomId = $roomId;
    }

    /**
     * {@inheritdoc}
     */
    public function write(array $record): void
    {
        $message = '[code]' . $this->getFormatter()->format($record) . '[/code]';

        $this->chatwork->room($this->roomId)->messages()->create($message);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new LineFormatter(null, null, true, true);
    }
}
