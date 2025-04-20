<?php
    class Car {
        public $name;
        public $price;
        public $images;

        public function __construct($name, $price, $images) {
            $this->name = $name;
            $this->price = $price;
            $this->images = $images;
        }
    }

    class CarList extends Car {
        public $type, $seats, $details, $discount, $oldPrice, $numberOfReviews, $reviewScore;

        public function __construct($images, $name, $type, $seats, $details, $discount, $oldPrice, $numberOfReviews, $reviewScore) {
            $price = $oldPrice - ($discount / 100 * $oldPrice);
            parent::__construct($name, $price, $images);
            $this->type = $type;
            $this->seats = $seats;
            $this->details = $details;
            $this->discount = $discount;
            $this->oldPrice = $oldPrice;
            $this->numberOfReviews = $numberOfReviews;
            $this->reviewScore = $reviewScore;
        }
    }

    class CarDetails extends Car {
        public $id, $seats, $suitcase, $features, $morefeatures;

        public function __construct($id, $name, $price, $images, $seats, $suitcase, $features, $morefeatures) {
            parent::__construct($name, $price, $images);
            $this->id = $id;
            $this->seats = $seats;
            $this->suitcase = $suitcase;
            $this->features = $features;
            $this->morefeatures = $morefeatures;
        }

        public function sortByCarId() {
            switch ($this->id) {
                case 0: sort($this->morefeatures); 
                        ksort($this->features); 
                        break;
                case 3: sort($this->morefeatures); 
                        asort($this->features); 
                        break;
                case 4: rsort($this->morefeatures); 
                        ksort($this->features); 
                        break;
                case 7: sort($this->morefeatures); 
                        arsort($this->features); 
                        break;
                case 8: rsort($this->morefeatures); 
                        krsort($this->features); 
                        break;
                default: 
                        break;
            }
        }
    }
?>
