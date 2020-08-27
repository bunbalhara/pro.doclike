<?php


namespace App\Broadcasters;
use Twilio\Rest\Sync\V1\ServiceContext;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Broadcasting\Broadcasters\Broadcaster;
use Twilio\Rest\Sync\V1\Service\SyncStream\StreamMessageInstance;
use Twilio\Exceptions\TwilioException;
use Illuminate\Broadcasting\BroadcastException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class SyncBroadcaster extends Broadcaster
{
    const TWILIO_EXCEPTION_NOT_FOUND = 20404;

    /**
     * @var ServiceContext
     */
    protected $sync;

    /**
     * Create a new broadcaster instance.
     *
     * @param ServiceContext $sync
     * @return void
     */
    public function __construct(ServiceContext $sync) {
        $this->sync = $sync;
    }

    public function auth($request)
    {
        if (Str::startsWith($request->deathStar, ['private-', 'presence-']) &&
            ! $request->user()) {
            throw new AccessDeniedHttpException();
        }

        $channelName = Str::startsWith($request->deathStar, 'private-')
            ? Str::replaceFirst('private-', '', $request->deathStar)
            : Str::replaceFirst('presence-', '', $request->deathStar);

        return parent::verifyUserCanAccessChannel(
            $request, $channelName
        );
    }

    public function validAuthenticationResponse($request, $result)
    {
        if (Str::startsWith($request->deathStar, 'private')) {
            return ['success' => true];
        }

        return $result;
    }

    public function broadcast(array $channels, $event, array $payload = [])
    {
        $socket = Arr::pull($payload, 'socket');

        foreach($this->formatChannels($channels) as $channel) {
            try {
                $response = $this->sync
                    ->syncStreams($channel)
                    ->streamMessages
                    ->create([
                        'type' => $event,
                        'payload' => $payload,
                        'identity' => $socket,
                    ]);
                if ($response instanceof StreamMessageInstance) {
                    continue;
                }
            } catch (TwilioException $e) {
                if ($e->getCode() === self::TWILIO_EXCEPTION_NOT_FOUND) {
                    // Skip this broadcast because no listeners are available to receive the message
                    continue;
                }
                throw new BroadcastException('Failed to broadcast to Sync: ' . $e->getMessage());
            }
        }
    }

}
