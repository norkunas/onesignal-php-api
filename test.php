<?php

require __DIR__ . '/vendor/autoload.php';

$r = new \Symfony\Component\OptionsResolver\OptionsResolver();
$r
    ->setDefined('filters')
    ->setAllowedTypes('filters', 'array')
    ->setNormalizer('filters', function (\Symfony\Component\OptionsResolver\Options $options, array $value) {
        $filters = [];

        if (isset($options['tags'])) {
            throw new \OneSignal\Exception\OneSignalException('You shouldn\'t use both filters and tags.');
        }

        foreach ($value as $filter) {
            if (isset($filter['field'], $filter['key'], $filter['relation'], $filter['value'])) {
                $filters[] = [
                    'field' => (string) $filter['field'],
                    'key' => (string) $filter['key'],
                    'relation' => (string) $filter['relation'],
                    'value' => $filter['value'],
                ];
            } elseif (isset($filter['operator'])) {
                $filters[] = ['operator' => 'OR'];
            }
        }

        return $filters;
    })
    ->setDefined('tags')
    ->setAllowedTypes('tags', 'array')
    ->setNormalizer('tags', function (\Symfony\Component\OptionsResolver\Options $options, array $value) {
        $tags = [];

        if (isset($options['filters'])) {
            throw new \OneSignal\Exception\OneSignalException('You shouldn\'t use both filters and tags.');
        }

        foreach ($value as $tag) {
            if (isset($tag['key'], $tag['relation'], $tag['value'])) {
                $tags[] = [
                    'key' => (string) $tag['key'],
                    'relation' => (string) $tag['relation'],
                    'value' => (string) $tag['value'],
                ];
            } elseif (isset($tag['operator'])) {
                $tags[] = ['operator' => 'OR'];
            }
        }

        return $tags;
    });

$g=$r->resolve([
    'filters' => [
        [
            'field' => 'tag',
            'key' => 'is_vip',
            'relation' => '!=',
            'value' => 'true',
        ],
        [
            'operator' => 'OR',
        ],
        [
            'field' => 'tag',
            'key' => 'is_admin',
            'relation' => '=',
            'value' => 'true',
        ]
    ],
    //'tags' => [],
]);
var_dump(json_encode($g, 15));
