<?php
declare(strict_types=1);

namespace Yireo\WebP2\Image;

use Exception;
use WebPConvert\WebPConvert;
use Yireo\WebP2\Config\Config;
use Yireo\WebP2\Resolver\UrlToPathResolver;

/**
 * Class Convertor
 *
 * @package Yireo\WebP2\Image
 */
class Convertor
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var File
     */
    private $file;

    /**
     * Convertor constructor.
     *
     * @param Config $config
     * @param File $file
     */
    public function __construct(
        Config $config,
        File $file
    ) {
        $this->config = $config;
        $this->file = $file;
    }

    /**
     * @param string $sourceImageUrl
     * @param string $destinationImageUrl
     *
     * @return bool
     */
    public function convert(string $sourceImageUrl, string $destinationImageUrl): bool
    {
        $sourceImageFilename = $this->getPathFromUrl($sourceImageUrl);
        $destinationImageFilename = $this->getPathFromUrl($destinationImageUrl);

        return WebPConvert::convert($sourceImageFilename, $destinationImageFilename, $this->getOptions());
    }

    /**
     * @param string $url
     *
     * @return string
     */
    private function getPathFromUrl(string $url): string
    {
        return $this->file->resolve($url);
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return [
            'quality' => 'auto',
            'max-quality' => $this->config->getQualityLevel(),
            'converters' => $this->config->getConvertors(),
        ];
    }
}