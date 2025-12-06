<?php

namespace App\Http\Controllers;

use App\Categorie;
use App\Models\Product;
use Illuminate\Http\Request;
use stdClass;

class ProductController extends Controller
{
    public function index()
    {
        $prods = Product::paginate(9);
        foreach ($prods as $prod) {
            if ($prod->reviews->avg("voto") > 4) {
                $prod->hot = true;
            }
        }

        return view("products.index", compact("prods"));
    }

    public function filterBySearch(Request $req)
    {
        $filters = $req->all();
        $fields = new stdClass();
        $cats = Categorie::cases();
        $filteredProds = Product::query();
        $taglie = ["XXS", "XS", "S", "M", "L", "XL", "XXL"];

        if (isset($filters['prezzoMin']) && isset($filters['prezzoMax'])) {
            if ($filters['prezzoMin'] > $filters['prezzoMax']) {
                return redirect()->back()->with('error', 'Il prezzo minimo non può essere superiore al prezzo massimo');
            }
        }

        foreach ($filters as $field => $value) {

            if ($value === null || $value === '') {
                continue;
            }

            if ($field == 'categoria') {
                if ($value == 'all') {
                    continue;
                } else {
                    $filteredProds = $filteredProds->where($field, $value);
                }
            }

            if ($field == 'nome') {
                $filteredProds = $filteredProds->where($field, "LIKE", "%{$value}%");
            }

            if ($field == 'taglie') {
                if (empty($value))
                    continue;
                $filteredProds = $filteredProds->where(function ($q) use ($value) {
                    foreach ($value as $t) {
                        $q->whereJsonContains('taglie', $t);
                    }
                });
            }

            if ($field == 'scontato') {
                $filteredProds->where($field, $value ? 1 : 0);
            }

            if ($field == 'prezzoMin' || $field == 'prezzoMax') {


                $filteredProds = $filteredProds
                ->whereRaw('prezzo - (prezzo * COALESCE(sconto, 0) / 100)'. ($field == 'prezzoMin' ? '>=' : '<=') . ' ?',  (int) $value);
            }

            $fields->{$field} = $value;
        }

        $prods = $filteredProds->paginate(9);

        if ($prods->isEmpty()) {
            return redirect()->back()->with('warning', 'Nessun prodotto trovato');
        }


        return view('products.cerca', compact('prods', 'cats', 'fields'));
    }

    public function resetFilters()
    {
        $cats = Categorie::cases();
        $prods = Product::paginate(9);
        $fields = new stdClass();

        return view('products.cerca', compact('prods', 'cats', 'fields'));
    }

    public function filtered($cat)
    {
        $prods = Product::where("categoria", $cat)->paginate(6);
        return view("products.filtered", compact("prods", "cat"));
    }

    public function details(Product $prod)
    {
        return view("products.details", compact("prod"));
    }

    public function discounted()
    {
        $prods = Product::with('reviews')
            ->where("scontato", 1)
            ->orderByDesc('sconto')
            ->paginate(6)
            ->through(function ($product) {
                $averageRating = $product->reviews->avg('voto');
                $product->average_rating = $averageRating;

                if ($averageRating > 4) {
                    $product->hot = true;
                }

                return $product;
            });

        return view("products.discounted", compact("prods"));
    }

}
