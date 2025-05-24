<?php
class Car
{
    private $name;
    public $price;
    private $images;

    public function __construct($name, $price, $images)
    {
        $this->name = $name;
        $this->price = $price;
        $this->images = $images;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setImages($images)
    {
        $this->images = $images;
    }
}

class CarList extends Car
{
    public $type, $seats, $details, $discount, $oldPrice, $numberOfReviews, $reviewScore;
    public $imagePath;
    public $numberOfSeats;
    public function __construct($images, $name, $type, $seats, $details, $discount, $oldPrice, $numberOfReviews, $reviewScore)
    {
        $price = $oldPrice - ($discount / 100 * $oldPrice);
        parent::__construct($name, $price, $images);
        $this->type = $type;
        $this->seats = $seats;
        $this->details = $details;
        $this->discount = $discount;
        $this->oldPrice = $oldPrice;
        $this->numberOfReviews = $numberOfReviews;
        $this->reviewScore = $reviewScore;

        $this->imagePath = count($images) > 0 ? $images[0] : 'images/default-car.jpg';
        $this->numberOfSeats = $seats;
    }

    public function getCarType()
    {
        return $this->type;
    }
}
class CarDetails extends Car
{
    public $id, $seats, $suitcase, $features, $morefeatures;

    public function __construct($id, $name, $price, $images, $seats, $suitcase, $features, $morefeatures)
    {
        parent::__construct($name, $price, $images);
        $this->id = $id;
        $this->seats = $seats;
        $this->suitcase = $suitcase;
        $this->features = $features;
        $this->morefeatures = $morefeatures;
    }
}

// 

function allcars($conn) {
    $cars = [];
    $query = "SELECT * FROM cars";
    $result = $conn->query($query);

    while ($eachrow = $result->fetch_assoc()) {
        $carid = $eachrow['id'];

        $details = [];
        $eachdetail = $conn->query("SELECT details FROM cardetails WHERE carid = $carid");
        while ($d = $eachdetail->fetch_assoc()) {
            $details[] = $d['details'];
        }

        $images = [];
        $eachimage = $conn->query("SELECT imgurl FROM carimages WHERE carid = $carid");
        while ($img = $eachimage->fetch_assoc()) {
            $images[] = $img['imgurl'];
        }

        $cars[] = (object) [
            'id' => $eachrow['id'],
            'name' => $eachrow['name'],
            'type' => $eachrow['type'],
            'seats' => $eachrow['seats'],
            'price' => $eachrow['price'],
            'oldPrice' => $eachrow['oldprice'],
            'discount' => $eachrow['discount'],
            'reviews' => $eachrow['reviews'],
            'reviewScore' => $eachrow['reviewscore'],
            'details' => $details,
            'images' => $images
        ];
    }

    return $cars;
}
?>