<?php

namespace MWI;

use \CFile as CFile;

/**
 * Class File
 * @package MWI
 */
class File extends CFile
{
    /**
     * @var array $data
     */
    private $data = array();

    /**
     * File constructor.
     * @param $id - file id
     */
    public function __construct($id)
    {
        $this->data = parent::GetFileArray($id);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->data['ID'];
    }

    /**
     * @return string
     */
    public function getSrc()
    {
        return $this->data['SRC'];
    }

    /**
     * @return string
     */
    public function getType()
    {
        return str_replace(array('.', '-'), '', explode('/', $this->getMimeType(), 2)[1]);
    }

    /**
     * @return string
     */
    private function getMimeType()
    {
        return $this->data['CONTENT_TYPE'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->data['ORIGINAL_NAME'];
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->sizeFormatted($this->data['FILE_SIZE']);
    }

    /**
     * @param $size - bytes
     * @return string
     */
    private function sizeFormatted($size)
    {
        $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

    /**
     * @return string
     */
    private function getFileName()
    {
        return $this->data['FILE_NAME'];
    }

    /**
     * @param $width
     * @param $height
     * @param string $type - available values ['BX_RESIZE_IMAGE_EXACT', 'BX_RESIZE_IMAGE_PROPORTIONAL', 'BX_RESIZE_IMAGE_PROPORTIONAL_ALT']
     * @return string
     */
    public function resize($width, $height, $type = 'BX_RESIZE_IMAGE_EXACT')
    {
        if (parent::isImage($this->getFileName(), $this->getMimeType())) {
            $resizedFile = parent::ResizeImageGet(
                $this->getId(),
                array(
                    'width' => $width,
                    'height' => $height
                ),
                $type,
                true
            );

            return $resizedFile["src"];
        }

        return $this->getSrc();
    }
}