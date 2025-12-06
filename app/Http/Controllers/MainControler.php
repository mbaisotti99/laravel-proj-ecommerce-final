<?php

namespace App\Http\Controllers;

use App\Categorie;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class MainControler extends Controller
{
    public function home()
    {
        $prods = Product::all();

        $bestProds = Product::with('reviews')
            ->get()
            ->map(function ($product) {

                $averageRating = $product->reviews->avg('voto');
                $product->average_rating = $averageRating;
                if ($averageRating > 4) {
                    $product->hot = true;
                }
                return $product;
            })
            ->sortByDesc('average_rating')
            ->take(3);

        $discountedProds = Product::where("scontato", 1)
            ->with("reviews")
            ->get()
            ->map(function ($product) {

                $averageRating = $product->reviews->avg('voto');
                $product->average_rating = $averageRating;
                if ($averageRating > 4) {
                    $product->hot = true;
                }
                return $product;
            })
            ->sortByDesc('sconto')
            ->take(3);


        return view("home", compact("bestProds", "discountedProds"));
    }

    public function cerca(){
        $prods = Product::paginate(10);
        $cats = Categorie::cases();

        return view('products.cerca', compact('prods', 'cats'));
    }

    public function contacts()
    {
        return view("info.contatti");
    }
    public function chiSiamo()
    {
        $revs = Review::where("voto", ">", 4)
            ->get()
            ->sortByDesc("voto")
            ->take(4);
        return view("info.chiSiamo", compact("revs"));
    }

}
