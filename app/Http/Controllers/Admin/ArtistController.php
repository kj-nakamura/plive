<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\ArtistRequest;
use App\Http\Requests\ArtistIndexRequest;
use App\Http\Controllers\Controller;
use App\Http\Model\Artist;
use Goutte\Client;

class ArtistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(ArtistIndexRequest $request)
    {
        $artists = Artist::search($request);
        return view('admin.artist.index', ['artists' => $artists]);
    }

    public function edit(Artist $artist)
    {
        return view('admin.artist.edit', ['artist' => $artist]);
    }

    public function update(ArtistRequest $request, Artist $artist)
    {
        // プレビュー
        $name = $request->name;
        $url = $request->url;
        $client = new Client();
        $crawler = $client->request('GET', $url);
        if ($request->action == "preview")
        {
            if ($crawler) {
                $crawler->filter($request->selector)->each(function ($li) use ($request) {
                    if ($li && $request->date_selector && $request->title_selector) {
                        $date = preg_replace("/\//", ".", $li->filter($request->date_selector)->text());
                        echo $d = preg_replace("/(\s+|\n|\r|\r\n|開催|\(.+\))/", "", $date);

                        echo '<br/>';

                        $title = preg_replace("/ |　/", "", $li->filter($request->title_selector)->text());
                        echo $t = preg_replace("/.+\..+\(.+\)/", "", $title);

                        echo '<br/>';
                        echo '<br/>';
                    } else {
                        echo 'セレクタが有効ではありません。';
                    }
                });

                return view(('admin.crawler.preview'),
                    [
                        'name' => $name,
                        'url' => $url,
                    ]
                );
            }
            return view('admin.crawler.index');
        }

        $artist->fill($request->all())->save();
        return redirect(route('admin::artist.edit', $artist))->with('result', __('c.updated'));
    }
}
