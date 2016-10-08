<?php

namespace App\Http\Controllers;

use App\Http\Repositories\MapRepository;
use Illuminate\Http\Request;

class MapController extends Controller
{
    protected $mapRepository;

    /**
     * MapController constructor.
     * @param MapRepository $mapRepository
     */
    public function __construct(MapRepository $mapRepository)
    {
        $this->mapRepository = $mapRepository;
        $this->middleware(['auth', 'admin']);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'key'   => 'required|unique:maps',
            'value' => 'required'
        ]);
        if ($this->mapRepository->create($request)) {
            return back()->with('success', 'Success');
        } else {
            return back()->withErrors('Failed');
        }
    }

    public function get($key)
    {
        $map = $this->mapRepository->get($key);
        if (is_null($map)) {
            abort(404);
        }

        return $map;
    }
}
