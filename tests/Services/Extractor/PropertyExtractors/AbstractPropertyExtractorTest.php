<?php

namespace DtoDragon\Test\Services\Extractor\PropertyExtractors;

use DtoDragon\DataTransferObject;
use DtoDragon\Services\Extractor\PropertyExtractors\AbstractPropertyExtractor;
use DtoDragon\Test\DtoDragonTestCase;
use ReflectionProperty;
use stdClass;

/**
 * @covers \DtoDragon\Services\Extractor\PropertyExtractors\AbstractPropertyExtractor
 */
class AbstractPropertyExtractorTest extends DtoDragonTestCase
{
    public function provideExtract(): array
    {
        $object = new stdClass();
        return [
            'null' => [
                null,
                null,
            ],
            'integer' => [
                1023213,
                1023213,
            ],
            'string' => [
                'string',
                'string',
            ],
            'float' => [
                1.2321,
                1.2321,
            ],
            'array' => [
                ['key' => 'value', 'test' => 12321],
                ['key' => 'value', 'test' => 12321],
            ],
            'object' => [
                $object,
                $object,
            ]
        ];
    }

    /**
     * @dataProvider provideExtract
     */
    public function testExtract($value, $expected): void
    {
        $dto = $this->createMock(DataTransferObject::class);
        $property = $this->createMock(ReflectionProperty::class);
        $property->expects(static::once())
            ->method('getValue')
            ->with($dto)
            ->willReturn($value);

        $extractor = new class extends AbstractPropertyExtractor {
            public function registeredType(): string
            {
                return 'does not matter';
            }
        };

        $actual = $extractor->extract($dto, $property);

        static::assertSame($expected, $actual);
    }
}