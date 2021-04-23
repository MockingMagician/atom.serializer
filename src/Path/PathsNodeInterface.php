<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Path;

interface PathsNodeInterface
{
    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param mixed $value
     */
    public function setValue($value);

    /**
     * @param string $path
     *
     * @return PathsNodeInterface the directly attached node to path
     */
    public function getChildNode($path);

    /**
     * @return PathsNodeInterface the parent node
     */
    public function getParentNode();

    /**
     * @param string[] $paths
     *
     * @return PathsNodeInterface the sub attached node that fill paths
     */
    public function getSubNode($paths);

    /**
     * @return string[] the paths that can match this node from the root node
     */
    public function getPaths();

    /**
     * @return string the paths given to that node referenced by it's parent node
     */
    public function getPathFromMyParent();

    /**
     * @param string $path
     *
     * @return PathsNodeInterface
     */
    public function attachNode($path);

    /**
     * @param string $path
     */
    public function detachNode($path);

    /**
     * @return int the number of time the node value has a reference into his parents
     */
    public function countReferencedValue();
}
