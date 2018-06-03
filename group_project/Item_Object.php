<?php


class Item_Object {
    private $title;
    private $brand;
    private $price;
    private $category;
    private $description;
    private $seller_email;
    private  $visited;
    private $id;
    private $link_to_image;

    public function __construct(string $brand,string $seller_email,float $price,string $description,
                                string $title,string $category,int $visited,int $id,string $link_to_image)
    {
        $this->brand = $brand;
        $this->seller_email = $seller_email;
        $this->price = $price;
        $this->description = $description;
        $this->title = $title;
        $this->category = $category;
        $this->visited = $visited;
        $this->id = $id;
        $this->link_to_image = $link_to_image;
    }

    public function get_brand(){return $this->brand;}
    public function  get_seller(){return $this->seller_email;}
    public function get_price(){return $this->price;}
    public function get_description(){return $this->description;}
    public function get_title(){return $this->title;}
    public function get_category(){return $this->category;}
    public function  get_visited(){return $this->visited;}
    public function get_id(){return $this->id;}
    public function get_link_to_image(){return $this->link_to_image;}

    public function set_brand(string $brand){ $this->brand = $brand;}
    public function  set_seller(string $email){$this->seller_email = $email;}
    public function set_price(float $price){$this->price = $price;}
    public function set_description(string $description){$this->description = $description;}
    public function set_title(string $title){$this->title = $title;}
    public function set_category(string $category){$this->category = $category;}
    public function set_visited(int $visited){$this->visited = $visited;}
    public function set_id(int $id){$this->id = $id;}
    public function set_link_to_image(string $link_to_image){$this->link_to_image = $link_to_image;}

    public function __toString()
    {
        $body=<<<EOBODY
        <em>$this->title</em><br>
        <b>Category : </b>$this->category<br>
        <b>ID number : </b>$this->id<br>
        <b>Brand : </b>$this->brand<br>
        <b>Price : </b><i>$this->price</i><br>
        <b>Seller's Contact : </b>$this->seller_email<br>
        <b>About Item</b><br>$this->description<br>
EOBODY;
        return $body;
    }

}