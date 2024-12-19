<?php

namespace App\DataPersister\Jobmap;

use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Jobmap\Inventory;
use App\Entity\Jobmap\Node;
use App\Entity\Jobmap\Element;

final class InventoryPersister implements ContextAwareDataPersisterInterface
{
    /** @var ContextAwareDataPersisterInterface  $decorated */
    private $decorated;
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    public function __construct(ContextAwareDataPersisterInterface $decorated, 
        EntityManagerInterface $entityManager)
    {
        $this->decorated = $decorated;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Inventory $data
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Inventory;
    }

    /**
     * @param Inventory $data
     */
    public function persist($data, array $context = [])
    {
        $inventory = $this->decorated->persist($data, $context);
        $inventory = $this->persistInventory($inventory);

        //$this->entityManager->persist($inventory);
        //$this->entityManager->flush();

        //return $inventory;
        //return $this->decorated->persist($inventory, $context);;
    }

    /**
     * @param Inventory $data
     */
    public function remove($data, array $context = [])
    {
        return $this->decorated->remove($data, $context);
    }

    public function persistInventory(Inventory $inventory): Inventory
    {
        $nodes = $inventory->getNodes();
        $inventory->setNodes(null);
        $this->entityManager->flush();

        $this->persistNodes($inventory, null, $nodes);
   
        return $inventory;
    }

    public function persistNodes(Inventory &$inventory, ?Node $parent, $nodes)
    {
        if ($nodes === null) {
            return;
        }
        $nodeData = [];
        /** @var Node $node */
        foreach ($nodes as $node) {     
            $node->setInventory($inventory);
            $node->setParent($parent);   

            $nodeData[] = [
                'node'   => $node, 
                'children' => $node->getChildren(), 
                'elements' => $node->getElements()
            ];
            $node->setChildren(null);
            $node->setElements(null);

            $this->entityManager->persist($node);
        }
        $this->entityManager->flush();

        foreach ($nodeData as $data) {
            $this->persistElements($data['node'], null, $data['elements']);
            $this->persistNodes($inventory, $data['node'], $data['children']);
        }

    }

    public function persistElements(Node $node, ?Element $parent, $elements)
    {
        if ($elements === null) {
            return;
        }
        $elementData = [];
        /** @var Element $element */
        foreach ($elements as $element) {
            $element->setNode($node);
            $element->setParent($parent);
            $elementData[] = [
                'element'     => $element, 
                'subElements' => $element->getSubElements(), 
                'attributes'  => $element->getAttributes()
            ];
            $element->setSubElements(null);
            $element->setAttributes(null);

            $this->entityManager->persist($element);
        }
        $this->entityManager->flush();

        foreach ($elementData as $data) {
            $this->persistAttributes($data['element'], $data['attributes']);
            $this->persistElements($node, $data['element'], $data['subElements']);
        }
    }

    public function persistAttributes(Element $element, $attributes)
    {
        if ($attributes === null) {
            return;
        }
        $element->setAttributes($attributes);
        foreach ($attributes as $attribute) {
            $this->entityManager->persist($attribute);
        }
        $this->entityManager->flush();
    }
}