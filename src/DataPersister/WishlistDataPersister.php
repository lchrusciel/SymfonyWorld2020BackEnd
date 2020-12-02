<?php

declare(strict_types=1);

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Wishlist;
use Sylius\Component\Customer\Context\CustomerContextInterface;
use Symfony\Component\VarDumper\VarDumper;

final class WishlistDataPersister implements DataPersisterInterface
{
    /**
     * @var DataPersisterInterface
     */
    private $decoratedDataPersister;
    /**
     * @var CustomerContextInterface
     */
    private $customerContext;

    public function __construct(DataPersisterInterface $decoratedDataPersister, CustomerContextInterface $customerContext)
    {
        $this->decoratedDataPersister = $decoratedDataPersister;
        $this->customerContext = $customerContext;
    }

    public function supports($data): bool
    {
        VarDumper::dump($data);
        return $data instanceof Wishlist;
    }

    /**
     * @param Wishlist $data
     */
    public function persist($data)
    {
        VarDumper::dump($data);
        $customer = $this->customerContext->getCustomer();

        $data->setCustomer($customer);

        VarDumper::dump($data);

        return $this->decoratedDataPersister->persist($data);
    }

    public function remove($data)
    {
        return $this->decoratedDataPersister->remove($data);
    }
}
