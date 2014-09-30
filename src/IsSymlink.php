<?php
/**
 * This file is part of FlysystemSftpSymlinkPlugin.
 *
 * @author      Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @copyright   2014 Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Flysystem\Plugin\Symlink\Sftp;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\PluginInterface;

/**
 * Sftp IsSymlink plugin.
 *
 * Implements a isSymlink($filename) method for Filesystem instances using SftpAdapter.
 */
class IsSymlink implements PluginInterface
{
    /**
     * FilesystemInterface instance.
     *
     * @var FilesystemInterface
     */
    protected $filesystem;

    /**
     * Sets the Filesystem instance.
     *
     * @param FilesystemInterface $filesystem
     */
    public function setFilesystem(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Gets the method name.
     *
     * @return string
     */
    public function getMethod()
    {
        return 'isSymlink';
    }

    /**
     * Method logic.
     *
     * Tells whether the specified $filename exists and is a symlink.
     *
     * @param   string  $filename   Filename.
     * @return  boolean             True if $filename is a symlink. Else false.
     */
    public function handle($filename)
    {
        $connection = $this->filesystem->getAdapter()->getConnection();
        $output = $connection->exec('if [ -h '.$filename.' ]; then echo 1; else echo 0; fi');

        return (trim($output) === '1');
    }
}