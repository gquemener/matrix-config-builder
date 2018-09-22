<?php

require __DIR__.'/vendor/autoload.php';


$php = new \GQuemener\MatrixConfigBuilder\Model\Variant('php', ['7.1', '7.2']);
$mysql = new \GQuemener\MatrixConfigBuilder\Model\Variant('mysql', ['5.6', '8']);
$postgres = new \GQuemener\MatrixConfigBuilder\Model\Variant('postgres', ['9', '10']);
$mariadb = new \GQuemener\MatrixConfigBuilder\Model\Variant('mariadb', ['10.2', '10.3']);
$db = \GQuemener\MatrixConfigBuilder\Model\Collection::oneOf($mysql, $postgres, $mariadb);
$req = \GQuemener\MatrixConfigBuilder\Model\Collection::allOf($php, $db);

$serializer = new \Symfony\Component\Serializer\Serializer(
    [
        new \GQuemener\MatrixConfigBuilder\Normalizer\Variant(),
        new \GQuemener\MatrixConfigBuilder\Normalizer\OneOf(),
        new \GQuemener\MatrixConfigBuilder\Normalizer\AllOf(),
    ],
    [
        new \Symfony\Component\Serializer\Encoder\YamlEncoder(),
    ]
);


die((
    $serializer->serialize($req, 'yaml', [
        'yaml_inline' => 2
    ])
));

/**
 * -
 *     php: '7.1'
 *     mysql: '5.6'
 * -
 *     php: '7.1'
 *     mysql: '8'
 * -
 *     php: '7.1'
 *     postgres: '9'
 * -
 *     php: '7.1'
 *     postgres: '10'
 * -
 *     php: '7.1'
 *     mariadb: '10.2'
 * -
 *     php: '7.1'
 *     mariadb: '10.3'
 * -
 *     php: '7.2'
 *     mysql: '5.6'
 * -
 *     php: '7.2'
 *     mysql: '8'
 * -
 *     php: '7.2'
 *     postgres: '9'
 * -
 *     php: '7.2'
 *     postgres: '10'
 * -
 *     php: '7.2'
 *     mariadb: '10.2'
 * -
 *     php: '7.2'
 *     mariadb: '10.3'
 */
