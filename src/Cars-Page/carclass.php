<?php
    class Car {
        private $name;
        public $price;
        private $images;

        public function __construct($name, $price, $images) {
            $this->name = $name;
            $this->price = $price;
            $this->images = $images;
        }

        public function getName() {
            return $this->name;
        }

        public function getImages() {
            return $this->images;
        }

        public function setName($name) {
            $this->name = $name;
        }

        public function setImages($images) {
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
    }
?>
