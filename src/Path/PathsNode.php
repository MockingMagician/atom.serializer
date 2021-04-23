<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Path;

class PathsNode implements PathsNodeInterface
{
    private $value;

    /** @var PathsNodeInterface[] */
    private $nodes = [];
    /**
     * @var null|PathsNodeInterface
     */
    private $parent;
    /**
     * @var null|string
     */
    private $myPath;

    /**
     * PathsNode constructor.
     *
     * @param null|PathsNodeInterface $parent
     * @param null|string             $pathFromMyParent
     * @param null|mixed              $value
     */
    public function __construct($parent = null, $pathFromMyParent = null, $value = null)
    {
        $this->parent = $parent;
        $this->value = $value;
        $this->myPath = $pathFromMyParent;
    }

    public function __destruct()
    {
        foreach ($this->nodes as $node) {
            $node->__destruct();
        }
        $this->nodes = [];
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getChildNode($path)
    {
        if (isset($this->nodes[$path])) {
            return $this->nodes[$path];
        }

        // TODO better to throw an exception ???
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubNode($paths)
    {
        $node = $this;
        foreach ($paths as $path) {
            $node = $node->getChildNode($path);
            if (!$node instanceof PathsNodeInterface) {
                return null;
            }
        }

        return $node;
    }

    /**
     * {@inheritdoc}
     */
    public function getPaths()
    {
        $node = $this->getParentNode();
        if (!$node instanceof PathsNodeInterface) {
            return [];
        }

        $paths = [];
        do {
            \array_unshift($paths, $node->getPathFromMyParent());
        } while (($node = $node->getParentNode()) instanceof PathsNodeInterface);

        return $paths;
    }

    /**
     * {@inheritdoc}
     */
    public function attachNode($path, $value = null)
    {
        $this->nodes[$path] = new self($this, $path, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function detachNode($path)
    {
        unset($this->nodes[$path]);
    }

    /**
     * {@inheritdoc}
     */
    public function countReferencedValue($countLimit = 1)
    {
        $value = $this->getValue();
        $count = 0;

        while ($node = $this->getParentNode()) {
            if ($node->getValue() === $value) {
                ++$count;
                if ($count >= $countLimit) {
                    break;
                }
            }
        }

        return $count;
    }

    /**
     * {@inheritdoc}
     */
    public function getParentNode()
    {
        return $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getPathFromMyParent()
    {
        return $this->myPath;
    }
}
