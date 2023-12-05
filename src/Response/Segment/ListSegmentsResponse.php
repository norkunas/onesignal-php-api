<?php

declare(strict_types=1);

namespace OneSignal\Response\Segment;

use OneSignal\Response\AbstractResponse;

final class ListSegmentsResponse implements AbstractResponse
{
    /**
     * @var int<0, 2147483648>
     */
    protected int $totalCount;

    /**
     * @var int<0, 2147483648>
     */
    protected int $offset;

    /**
     * @var int<0, 2147483648>
     */
    protected int $limit;

    /**
     * @var list<Segment>
     */
    protected array $segments;

    /**
     * @param int<0, 2147483648> $totalCount
     * @param int<0, 2147483648> $limit
     * @param int<0, 2147483648> $offset
     * @param list<Segment>      $segments
     */
    public function __construct(int $totalCount, int $offset, int $limit, array $segments)
    {
        $this->totalCount = $totalCount;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->segments = $segments;
    }

    public static function makeFromResponse(array $request): self
    {
        $segments = array_map(
            static function (array $segment): Segment {
                return new Segment(
                    $segment['id'],
                    $segment['name'],
                    $segment['created_at'],
                    $segment['updated_at'],
                    $segment['app_id'],
                    $segment['read_only'],
                    $segment['is_active'],
                );
            },
            $request['segments']
        );

        return new static(
            $request['total_count'],
            $request['offset'],
            $request['limit'],
            $segments
        );
    }

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return list<Segment>
     */
    public function getSegments(): array
    {
        return $this->segments;
    }
}
