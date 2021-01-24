<?php


namespace MWI;

/**
 * Class ServiceOffer
 * @package MWI
 */
class ServiceOffer implements IBEntityInterface
{
    use IBEntityValidatorTrait,
        LangIBInfoTrait;

    /**
     * @var array IBLOCK_ID
     * @var array IBLOCK_TYPE
     * @var int $id
     * @var string $name
     * @var int $price
     * @var float|int $discountPrice
     */
    const IBLOCK_ID = array(
        'ru' => 29,
        'en' => 45,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'catalog',
        'en' => 'catalog_en',
    );

    public $id;
    public $name;
    public $price;
    public $discountPrice;

    /**
     * ServiceOffer constructor.
     * @param $id
     */
    public function __construct($id)
    {
        if ($this->isValidId($id)) {
            $this->id = $id;
        }
    }

    /**
     *
     */
    public function makeData()
    {
        // TODO: Implement makeData() method.
    }

    /**
     *
     */
    public function makeDiscountPrice()
    {
        $discountPrice = $this->price - $this->getMaxDiscount();

        $this->discountPrice = ($discountPrice >= 0) ? $discountPrice : $this->price;
    }

    /**
     * get max discount from all stocks
     * @return float|int
     */
    private function getMaxDiscount()
    {
        $discount = 0;

        $obOffer = new ServiceOffer($this->id);
        $obOffers = new ServiceOfferList();
        $obOffers->add($obOffer);

        $stockList = $obOffers->getStocks();
        foreach ($stockList->getList() as $obStock) {
            $discountAmount = $this->getDiscountAmount($obStock->amount, $obStock->percentage);
            if ($discountAmount > $discount) {
                $discount = $discountAmount;
            }
        }

        return $discount;
    }

    /**
     * @param $amount
     * @param bool $percentage
     * @return float|int
     */
    private function getDiscountAmount($amount, $percentage = false)
    {
        return $percentage ? ($this->price * ($amount / 100)) : $amount;
    }
}