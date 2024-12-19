<?php
namespace App\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="uploaded_files")
 * @Gedmo\Uploadable(filenameGenerator="SHA1", allowOverwrite=true, appendNumber=true)
 */
class UploadedFile implements \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="path", type="string")
     * @Gedmo\UploadableFilePath
     */
    private $path;

    /**
     * @ORM\Column(name="name", type="string")
     * @Gedmo\UploadableFileName
     */
    private $name;

    /**
     * @ORM\Column(name="mime_type", type="string")
     * @Gedmo\UploadableFileMimeType
     */
    private $mimeType;

    /**
     * @ORM\Column(name="size", type="decimal")
     * @Gedmo\UploadableFileSize
     */
    private $size;

    private $webpath;

    /**
     * @Assert\File()
     */
    private $file;

    public function getId() : int {
        return $this->id;
    }

    public function getPath() : ?string {
        return $this->path;
    }

    public function getName() : ?string {
        return $this->name;
    }

    public function getMimeType() : ?string {
        return $this->mimeType;
    }

    public function getSize() : ?int {
        return $this->size;
    }

    public function setFile($file): self
    {
        $this->file = $file;
        return $this;
    }

    public function getFile() {
        return $this->file;
    }

    public function getWebPath() : ?string {
        if ($this->webpath === null) {
            //the file path is an absolute on the file system, but we only need the relative web path.
            $re = '/^.+?\.\.\/public\/(.+)$/m';
            preg_match($re, $this->getPath(), $matches);
            if (isset($matches[1])) {
                $this->webpath = $matches[1];
            }
        }

        return $this->webpath;
    }

    public function serialize() {
        return serialize([
            $this->getId(),
            $this->getPath(),
            $this->getName(),
            $this->getMimeType(),
            $this->getSize()
        ]);
    }

    public function unserialize($serialized) {
        list (
            $this->id, 
            $this->path,
            $this->name,
            $this->mimeType,
            $this->size
        ) = unserialize($serialized, ['allowed_classes' => false]);
    }
}